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
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Invalid login details',
            ], 401);
        }

        // Use Auth::user() instead of querying the database again
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Login successfully',
            'data' => [
                'token' => $token,
                'user' => $user,
            ],
        ], 200);
    }

    public function socialLogin(Request $request)
    {
        $request->validate([
            'provider' => 'required|in:google,facebook',
            'token' => 'required',
        ]);

        try {
            // Use stateless() because this is an API
            $socialUser = Socialite::driver($request->provider)->stateless()->userFromToken($request->token);

            // Check if user exists by email or provider_id
            $user = User::where('email', $socialUser->getEmail())
                ->orWhere('provider_id', $socialUser->getId())
                ->first();

            if (! $user) {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'profile_image' => $socialUser->getAvatar(),
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $request->provider,
                    'password' => null,
                ]);
            } else {
                $user->update([
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $request->provider,
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Social login successful',
                'data' => [
                    'token' => $token,
                    'user' => $user,
                ],
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid social token',
                'error' => $e->getMessage(),
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // FIXED: was unique:users,name
            'phone' => 'required|unique:users,phone',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'password' => 'required|min:8', // FIXED: min:3 is insecure
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

            // Send welcome notification
            $user->notify(new UserWelcomeAPINotifcation($user));

            return response()->json([
                'success' => true,
                'status' => 201,
                'message' => 'Registration successful',
                'registration_data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed', // FIXED: was 'Invalid social token'
                'error' => $e->getMessage(),
            ], 500);
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

        $response = Password::broker('users')->sendResetLink([
            'email' => $request->email,
        ]);

        return $response == Password::RESET_LINK_SENT
                ? $this->sendResetLinkResponse($request, $response)
                : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function sendResetLinkResponse($request, $response)
    {
        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Reset link sent to your email.',
        ], 200);
    }

    protected function sendResetLinkFailedResponse($request, $response)
    {
        return response()->json([
            'success' => false,
            'status' => 401,
            'message' => 'We could not send the reset link.',
        ], 401);
    }

    public function logout(Request $request)
    {
        // Use the request user to delete the token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Logout successful',
        ], 200);
    }
}
