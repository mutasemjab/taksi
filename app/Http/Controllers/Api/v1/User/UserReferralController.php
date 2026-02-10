<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            
            // Get stats
            $stats = $this->referralService->getUserReferralStats($user);
            
            // Get detailed list
            $perPage = $request->get('per_page', 15);
            $referralList = $this->referralService->getUserReferralList($user, $perPage);
            
            // Format the list
            $formattedList = $referralList->map(function ($referral) {
                $referred = $referral->referred;
                
                return [
                    'id' => $referral->id,
                    'referred_name' => $referred->name ?? 'N/A',
                    'referred_phone' => $referred->phone ?? 'N/A',
                    'referred_type' => $referral->referred_type,
                    'orders_completed' => $referral->orders_completed,
                    'reward_paid' => $referral->reward_paid,
                    'reward_amount' => $referral->reward_amount,
                    'joined_date' => $referral->created_at->format('Y-m-d H:i:s'),
                    'formatted_date' => $referral->created_at->diffForHumans(),
                    'reward_paid_at' => $referral->reward_paid_at ? $referral->reward_paid_at->format('Y-m-d H:i:s') : null,
                ];
            });
            
            return response()->json([
                'status' => true,
                'data' => [
                    'referral_code' => $user->referral_code,
                    'stats' => $stats,
                    'referred_list' => $formattedList,
                    'pagination' => [
                        'total' => $referralList->total(),
                        'per_page' => $referralList->perPage(),
                        'current_page' => $referralList->currentPage(),
                        'last_page' => $referralList->lastPage(),
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
}