<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Customhelpers;
use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\User;
use App\Models\UserCoinTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CallingController extends Controller
{
    public function match()
    {
        $userid = auth()->id();
        $selectUser = User::findOrFail($userid);
        $gendertosearch = $selectUser->gender === 'male'
            ? 'female'
            : 'male';
        $matchedUser = User::where('gender', $gendertosearch)
            ->where('id', '!=', $userid)
            ->inRandomOrder()
            ->first();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Match user fetched successfully',
            'data' => $matchedUser,
        ], 200);
    }

    public function start(Request $request)
    {
        $request->validate([
            'calle_id' => ['required', 'exists:users,id'],
        ]);
        $userid = auth()->id();
        // Don't allow calling yourself
        if ($userid == $request->calle_id) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'You cannot call yourself.',
            ], 422);
        }

        $coin = (int) Customhelpers::settingByKey('call_start_coin');
        $user = User::where('id', $userid)
            ->lockForUpdate()
            ->firstOrFail();
        $coinBefore = (int) $user->coins;
        if ($coinBefore < $coin) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Insufficient coins to start the call.',
            ], 400);
        }

        $call = Call::create([
            'uuid' => (string) Str::uuid(),
            'caller_id' => $userid,
            'calle_id' => $request->calle_id,
            'status' => 'calling',
        ]);

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Caller initiated successfully',
            'data' => $call,
        ], 200);
    }

    public function connected(Request $request)
    {
        $request->validate([
            'uuid' => ['required', 'uuid'],
        ]);
        DB::beginTransaction();
        try {
            $call = Call::where('uuid', $request->uuid)
                ->lockForUpdate()
                ->firstOrFail();
            // Prevent connecting an already connected/ended/rejected call
            if ($call->status !== 'calling') {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => 'Call cannot be connected because its current status is '.$call->status,
                ], 400);
            }
            $call->update([
                'status' => 'connected',
                'call_start' => now(),
            ]);
            $coin = (int) Customhelpers::settingByKey('call_start_coin');
            $user = User::where('id', $call->caller_id)
                ->lockForUpdate()
                ->firstOrFail();
            $coinBefore = (int) $user->coins;
            // Not enough coins
            if ($coinBefore < $coin) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => 'Insufficient coins to start the call.',
                ], 400);
            }
            $coinAfter = $coinBefore - $coin;
            $user->update([
                'coins' => $coinAfter,
            ]);
            $coinTransaction = UserCoinTransaction::create([
                'user_id' => $call->caller_id,
                'status' => 'debit',
                'type' => 'call_start',
                'coins' => $coin,
                'coin_before' => $coinBefore,
                'coin_after' => $coinAfter,
                'description' => 'Call start deduction',
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Call has been connected successfully',
                'data' => [
                    'call' => $call,
                    'cointransaction' => $coinTransaction,
                ],
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function end(Request $request)
    {
        $request->validate([
            'uuid' => ['required', 'uuid'],
        ]);
        DB::beginTransaction();
        try {
            $call = Call::where('uuid', $request->uuid)
                ->lockForUpdate()
                ->firstOrFail();
            // Already ended
            if ($call->status === 'ended') {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => 'Call has already been ended.',
                ], 400);
            }
            // Only connected calls can be charged
            // if ($call->status !== 'connected') {
            //     DB::rollBack();

            //     return response()->json([
            //         'success' => false,
            //         'status' => 400,
            //         'message' => 'Only connected calls can be ended.',
            //     ], 400);
            // }
            $callEnd = now();
            $callStart = $call->call_start;
            $duration = $callStart->diffInSeconds($callEnd);
            $call->update([
                'status' => 'ended',
                'end_reason' => 'Call has been ended',
                'call_end' => $callEnd,
                'duration' => $duration,
            ]);
            $coinPerBilling = (int) Customhelpers::settingByKey(
                'call_per_minute_coin'
            );
            $billingMinutes = (int) Customhelpers::settingByKey('call_per_minute');
            // Charge every started minute
            $billingBlocks = (int) ceil($duration / ($billingMinutes * 60));
            $totalCoin = $billingBlocks * $coinPerBilling;
            $user = User::where('id', $call->caller_id)
                ->lockForUpdate()
                ->firstOrFail();
            $coinBefore = (int) $user->coins;
            $actualDeduction = min(
                $coinBefore,
                $totalCoin
            );
            $coinAfter = $coinBefore - $actualDeduction;
            $user->update([
                'coins' => $coinAfter,
            ]);
            $coinTransaction = UserCoinTransaction::create([
                'user_id' => $call->caller_id,
                'status' => 'debit',
                'type' => 'call',
                'coins' => $actualDeduction,
                'coin_before' => $coinBefore,
                'coin_after' => $coinAfter,
                'description' => 'Call ended deduction',
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Call has been ended successfully',
                'data' => [
                    'call' => $call,
                    'cointransaction' => $coinTransaction,
                ],
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function rejected(Request $request)
    {
        $request->validate([
            'uuid' => ['required', 'uuid'],
        ]);
        DB::beginTransaction();
        try {
            $call = Call::where('uuid', $request->uuid)
                ->lockForUpdate()
                ->firstOrFail();
            if ($call->status !== 'calling') {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => 'This call cannot be rejected.',
                ], 400);
            }
            $call->update([
                'status' => 'rejected',
                'end_reason' => 'Call has been rejected',
                'call_end' => now(),
                'duration' => 0,
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Call has been rejected successfully',
                'data' => $call,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
