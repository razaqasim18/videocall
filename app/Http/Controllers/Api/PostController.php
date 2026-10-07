<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function followingPosts(Request $request)
    {
        $userId = auth()->id();

        $limit = $request->input('limit', 10);

        $posts = Post::whereIn('user_id', function ($query) use ($userId) {
            $query->select('following_id')
                ->from('follows')
                ->where('follower_id', $userId);
        })
            ->with('user')
            ->latest()
            ->paginate($limit);

        return response()->json([
            'success' => true,
            'message' => 'Following posts fetched successfully',
            'data' => $posts->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'has_more' => $posts->hasMorePages(),
            ],
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'body' => ['nullable', 'string', 'max:5000', 'required_without:media'],
            'media' => [
                'nullable',
                'file',
                'required_without:body',
                'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/quicktime,video/x-msvideo,video/webm',
                'max:51200',
            ],
            'thumbnail' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        // Post type
        $type = Post::TYPE_TEXT;

        if ($request->hasFile('media')) {
            $mime = $request->file('media')->getMimeType();

            $type = str_starts_with($mime, 'video/')
                ? Post::TYPE_VIDEO
                : Post::TYPE_IMAGE;

            if ($type === Post::TYPE_IMAGE && $request->file('media')->getSize() > 5 * 1024 * 1024) {
                return $this->error('Image must not be larger than 5 MB.', 422);
            }
        }

        // Store media
        $mediaPath = null;
        $thumbnailPath = null;

        if ($type === Post::TYPE_IMAGE) {
            $mediaPath = $request->file('media')->store('uploads/posts/images', 'public');
        }

        if ($type === Post::TYPE_VIDEO) {
            $mediaPath = $request->file('media')->store('uploads/posts/videos', 'public');

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')
                    ->store('uploads/posts/thumbnails', 'public');
            }
        }

        // Create post
        try {
            $post = Post::create([
                'user_id' => $request->user()->id,
                'type' => $type,
                'body' => $request->body,
                'media_path' => $mediaPath,
                'thumbnail_path' => $thumbnailPath,
            ]);
        } catch (\Throwable $e) {

            if ($mediaPath) {
                Storage::disk('public')->delete($mediaPath);
            }

            if ($thumbnailPath) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            report($e);

            return $this->error('Something went wrong.', 500);
        }

        return $this->success(
            'Post created successfully.',
            $post->load('user:id,name'),
            201
        );
    }

    public function comment(Request $request)
    {
        $validated = $request->validate([
            'post_id' => ['required', 'integer', 'exists:posts,id'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $comment = DB::transaction(function () use ($request, $validated) {

            $comment = Comment::create([
                'post_id' => $validated['post_id'],
                'user_id' => $request->user()->id,
                'body' => $validated['body'],
            ]);

            Post::whereKey($validated['post_id'])
                ->increment('comments_count');

            return $comment;
        });

        return $this->success(
            'Comment added successfully.',
            $comment->load('user:id,name'),
            201
        );
    }

    public function like(Request $request)
    {
        $validated = $request->validate([
            'post_id' => ['required', 'integer', 'exists:posts,id'],
        ]);

        $post = Post::findOrFail($validated['post_id']);

        return $this->toggleLike(
            $post,
            $request->user()->id,
            'Post'
        );
    }

    public function commentLike(Request $request)
    {
        $validated = $request->validate([
            'comment_id' => ['required', 'integer', 'exists:comments,id'],
        ]);

        $comment = Comment::findOrFail($validated['comment_id']);

        return $this->toggleLike(
            $comment,
            $request->user()->id,
            'Comment'
        );
    }

    public function commentReply(Request $request)
    {
        $validated = $request->validate([
            'comment_id' => ['required', 'integer', 'exists:comments,id'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $parent = Comment::findOrFail($validated['comment_id']);

        $reply = DB::transaction(function () use ($request, $validated, $parent) {

            $reply = Comment::create([
                'post_id' => $parent->post_id,
                'user_id' => $request->user()->id,
                'parent_id' => $parent->id,
                'body' => $validated['body'],
            ]);

            $parent->increment('replies_count');

            Post::whereKey($parent->post_id)
                ->increment('comments_count');

            return $reply;
        });

        return $this->success(
            'Reply added successfully.',
            $reply->load('user:id,name'),
            201
        );
    }

    private function toggleLike(Model $model, int $userId, string $label)
    {

        $liked = DB::transaction(function () use ($model, $userId) {

            $like = $model->likes()
                ->where('user_id', $userId)
                ->first();

            if ($like) {
                $like->delete();

                if ($model->likes_count > 0) {
                    $model->decrement('likes_count');
                }

                return false;
            }

            $model->likes()->create([
                'user_id' => $userId,
            ]);

            $model->increment('likes_count');

            return true;
        });

        return $this->success(
            $liked ? "$label liked." : "$label unliked.",
            [
                'liked' => $liked,
                'likes_count' => $model->fresh()->likes_count,
            ]
        );
    }

    private function success(string $message, $data = null, int $status = 200)
    {
        return response()->json([
            'success' => true,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    private function error(string $message, int $status = 400)
    {
        return response()->json([
            'success' => false,
            'status' => $status,
            'message' => $message,
        ], $status);
    }
}
