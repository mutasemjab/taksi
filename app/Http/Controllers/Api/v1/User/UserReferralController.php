<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Services\ReferralService;
use App\Models\ReferralReward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserReferralController extends Controller
{
    protected $referralService;
    
    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }
    
    /**
     * Get comprehensive referral information
     */
    public function getReferralInfo(Request $request)
    {
        try {
            $user = Auth::guard('user-api')->user();
            
            // Get settings
            $ordersRequiredForReward = $this->getSetting('number_of_order_to_get_reward', 1);
            $userReferralReward = $this->getSetting('user_referral_user_reward', 5);
            $driverReferralReward = $this->getSetting('driver_referral_user_reward', 10);
            
            // Get all referrals
            $allReferrals = ReferralReward::where('referrer_id', $user->id)
                ->where('referrer_type', 'user')
                ->with(['referred'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Calculate totals
            $totalReferrals = $allReferrals->count();
            $totalEarnings = $allReferrals->where('reward_paid', true)->sum('reward_amount');
            
            // Paginate for list
            $perPage = $request->get('per_page', 15);
            $page = $request->get('page', 1);
            
            // Format the list with all required details
            $formattedList = $allReferrals->map(function ($referral) use ($ordersRequiredForReward, $userReferralReward, $driverReferralReward) {
                $referred = $referral->referred;
                $rewardAmount = $referral->referred_type === 'user' ? $userReferralReward : $driverReferralReward;
                
                return [
                    'id' => $referral->id,
                    'referred_name' => $referred->name ?? 'N/A',
                    'referred_phone' => $referred->phone ?? 'N/A',
                    'referred_photo_url' => $referred->photo_url ?? null,
                    'referred_type' => $referral->referred_type,
                    
                    // Progress details
                    'orders_completed' => $referral->orders_completed,
                    'orders_required' => $ordersRequiredForReward,
                    'orders_remaining' => max(0, $ordersRequiredForReward - $referral->orders_completed),
                    'progress_percentage' => min(100, ($referral->orders_completed / $ordersRequiredForReward) * 100),
                    
                    // Reward details
                    'reward_paid' => $referral->reward_paid,
                    'reward_amount' => $referral->reward_paid ? (float) $referral->reward_amount : $rewardAmount,
                    'expected_reward' => $rewardAmount,
                    
                    // Status
                    'status' => $referral->reward_paid ? 'rewarded' : ($referral->orders_completed >= $ordersRequiredForReward ? 'pending_payment' : 'in_progress'),
                    
                    // Dates
                    'joined_date' => $referral->created_at->format('Y-m-d H:i:s'),
                    'formatted_date' => $referral->created_at->diffForHumans(),
                    'reward_paid_at' => $referral->reward_paid_at ? $referral->reward_paid_at->format('Y-m-d H:i:s') : null,
                ];
            });
            
            // Paginate manually
            $total = $formattedList->count();
            $items = $formattedList->forPage($page, $perPage)->values();
            
            return response()->json([
                'status' => true,
                'data' => [
                    'referral_code' => $user->referral_code,
                    'total_referrals' => $totalReferrals,
                    'total_earnings' => (float) $totalEarnings,
                    'orders_required_for_reward' => $ordersRequiredForReward,
                    'reward_per_user_referral' => (float) $userReferralReward,
                    'reward_per_driver_referral' => (float) $driverReferralReward,
                    'referred_list' => $items,
                    'pagination' => [
                        'total' => $total,
                        'per_page' => $perPage,
                        'current_page' => $page,
                        'last_page' => $total > 0 ? ceil($total / $perPage) : 1,
                    ]
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching referral information',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get setting value
     */
    private function getSetting($key, $default = 0)
    {
        return DB::table('settings')->where('key', $key)->value('value') ?? $default;
    }
}