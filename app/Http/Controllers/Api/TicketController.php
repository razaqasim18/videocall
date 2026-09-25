<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use App\Notifications\TicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function list()
    {
        $data = Ticket::where('senderable_id', auth()->id())
            ->where('senderable_type', User::class)->get();

        return response()->json([
            'success' => false,
            'status' => 200,
            'message' => 'data has been fetched successfully',
            'data' => $data,
        ], 200);
    }

    public function detail(Request $request)
    {
        $ticket = Ticket::with('replies')->findorFail($request->id);

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Ticket created successfully',
            'data' => $ticket,
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $ticket = new Ticket;
        $ticket->ticket_no = (string) Str::uuid();
        $ticket->senderable_id = auth()->id();
        $ticket->senderable_type = User::class;
        $ticket->subject = $request->subject;
        $ticket->message = $request->message;
        $ticket->priority = 'medium';
        $ticket->status = 'open';

        // 3. Save the ticket (use save(), NOT update())
        if ($ticket->save()) {
            $admin = Admin::first();
            $admin->notify(new TicketNotification($ticket, 'user', 'new'));

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Ticket created successfully',
                'data' => $ticket,
            ], 200);
        } else {

            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    public function reply(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $ticket = Ticket::findorFail($request->id);

        $reply = TicketReply::create([
            'ticket_id' => $request->id,
            'senderable_type' => User::class,
            'senderable_id' => auth()->id(),
            'message' => $request->message,
        ]);

        if ($ticket->save()) {
            $admin = Admin::first();
            $admin->notify(new TicketNotification($ticket, 'user', 'reply'));

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Ticket replay created successfully',
                'data' => $reply,
            ], 200);
        } else {

            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Something went wrong',
            ], 500);
        }
    }
}
