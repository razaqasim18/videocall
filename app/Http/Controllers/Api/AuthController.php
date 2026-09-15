<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserWelcomeAPINotifcation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
            'token' => $token,
            'user' => $user,
        ];

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'login succesafully',
            'data' => $data,
        ], 200);

    }

    // Social Login (Google & Facebook)
    public function socialLogin(Request $request)
    {
        $request->validate([
            'provider' => 'required|in:google,facebook',
            'token' => 'required', // Token sent from Mobile App
        ]);

        try {
            // Use stateless() because this is an API
            $socialUser = Socialite::driver($request->provider)->stateless()->userFromToken($request->token);

            // Check if user exists by email or provider_id
            $user = User::where('email', $socialUser->getEmail())
                ->orWhere('provider_id', $socialUser->getId())
                ->first();

            if (! $user) {
                // Create new user if not found
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'profile_image' => $socialUser->getAvatar(),
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $request->provider,
                    'password' => null, // No password for social users
                ]);
            } else {
                // Update provider info if they registered with email first
                $user->update([
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $request->provider,
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $data = [
                'token' => $token,
                'user' => $user,
            ];

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'login succesafully',
                'data' => $data,
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => 'Invalid social token', 'error' => $e->getMessage()], 401);
        }
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,name',
            'phone' => 'required|unique:users,phone',
            'dob' => 'required',
            'gender' => 'required',
            'password' => 'required|min:3|max:8',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validation->errors(),
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'dob' => $request->dob,
                'phone' => $request->phone,
                'gender' => $request->gender,
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
            $user->notify(new UserWelcomeAPINotifcation($user));

            return response()->json(
                [
                    'success' => true,
                    'status' => 201,
                    'message' => 'Registration successful',
                    'registration_data' => [
                        'user' => $user,
                        'token' => $token,
                    ],
                ],
                201,
            );

        } catch (Exception $e) {
            return response()->json(['message' => 'Invalid social token', 'error' => $e->getMessage()], 401);
        }

    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }

        // This triggers the process.
        $response = Password::broker('users')->sendResetLink($request->only('email'));

        // FIX: You MUST use 'return' here, otherwise the browser gets no response
        return $response == Password::RESET_LINK_SENT
                ? $this->sendResetLinkResponse($request, $response)
                : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function sendResetLinkResponse($request, $response)
    {
        return response()->json(
            [
                'success' => true,
                'status' => 200,
                'message' => 'Reset link sent to your email.',
            ],
            200,
        );
    }

    protected function sendResetLinkFailedResponse($request, $response)
    {
        return response()->json(
            [
                'success' => false,
                'status' => 401,
                'message' => 'We could not send the reset link.',
            ],
            401,
        );
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json(
            [
                'success' => true,
                'status' => 200,
                'message' => 'Logout successful',
            ],
            200,
        );
    }
}
