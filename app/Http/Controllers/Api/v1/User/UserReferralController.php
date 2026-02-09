<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Driver;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserReferralController extends Controller
{
    /**
     * Get comprehensive referral information including stats, challenges, and referred users list
     * 
     * Query Parameters:
     * - per_page: Number of items per page (default: 15)
     * - type: Filter type ('all', 'users', 'drivers') (default: 'all')
     * - page: Page number (default: 1)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReferralInfo(Request $request)
    {
        try {
            $user = Auth::guard('user-api')->user();
            
            // Pagination parameters
            $perPage = $request->get('per_page', 15);
            $type = $request->get('type', 'all'); // all, users, drivers
            $page = $request->get('page', 1);
            
            // Get referred users
            $referredUsers = [];
            $referredDrivers = [];
            
            if ($type === 'all' || $type === 'users') {
                $referredUsers = User::where('user_id', $user->id)
                    ->select('id', 'name', 'phone', 'photo', 'created_at')
                    ->get()
                    ->map(function ($refUser) {
                        return [
                            'id' => $refUser->id,
                            'name' => $refUser->name,
                            'phone' => $refUser->phone,
                            'photo_url' => $refUser->photo_url,
                            'type' => 'user',
                            'joined_date' => $refUser->created_at->format('Y-m-d H:i:s'),
                            'formatted_date' => $refUser->created_at->diffForHumans(),
                        ];
                    });
            }
            
            if ($type === 'all' || $type === 'drivers') {
                $referredDrivers = Driver::where('user_id', $user->id)
                    ->select('id', 'name', 'phone', 'photo', 'created_at')
                    ->get()
                    ->map(function ($refDriver) {
                        return [
                            'id' => $refDriver->id,
                            'name' => $refDriver->name,
                            'phone' => $refDriver->phone,
                            'photo_url' => $refDriver->photo_url,
                            'type' => 'driver',
                            'joined_date' => $refDriver->created_at->format('Y-m-d H:i:s'),
                            'formatted_date' => $refDriver->created_at->diffForHumans(),
                        ];
                    });
            }
            
            // Merge and sort by date
            $allReferrals = collect($referredUsers)
                ->merge($referredDrivers)
                ->sortByDesc('joined_date')
                ->values();
            
            // Calculate counts
            $referredUsersCount = User::where('user_id', $user->id)->count();
            $referredDriversCount = Driver::where('user_id', $user->id)->count();
            $totalReferrals = $referredUsersCount + $referredDriversCount;
            
            // Paginate
            $total = $allReferrals->count();
            $items = $allReferrals->forPage($page, $perPage)->values();
            
            // Calculate total earnings from completed referral challenges
            $totalEarnings = DB::table('user_challenge_progress')
                ->join('challenges', 'user_challenge_progress.challenge_id', '=', 'challenges.id')
                ->where('user_challenge_progress.user_id', $user->id)
                ->where('challenges.challenge_type', 'referral')
                ->where('user_challenge_progress.is_completed', true)
                ->sum(DB::raw('challenges.reward_amount * user_challenge_progress.times_completed'));
            
            // Get referral challenge progress
            $referralChallenges = Challenge::active()
                ->ofType('referral')
                ->get()
                ->map(function ($challenge) use ($user) {
                    $progress = $user->getChallengeProgress($challenge->id);
                    
                    return [
                        'id' => $challenge->id,
                        'title' => $challenge->getTitle(request()->header('Accept-Language', 'en')),
                        'description' => $challenge->getDescription(request()->header('Accept-Language', 'en')),
                        'target_count' => $challenge->target_count,
                        'current_count' => $progress->current_count,
                        'reward_amount' => $challenge->reward_amount,
                        'is_completed' => $progress->is_completed,
                        'times_completed' => $progress->times_completed,
                        'max_completions' => $challenge->max_completions_per_user,
                        'can_complete_again' => $progress->times_completed < $challenge->max_completions_per_user,
                        'progress_percentage' => min(100, ($progress->current_count / $challenge->target_count) * 100),
                    ];
                });
            
            return response()->json([
                'status' => true,
                'data' => [
                    'referral_code' => $user->referral_code,
                    'total_referrals' => $totalReferrals,
                    'referred_users_count' => $referredUsersCount,
                    'referred_drivers_count' => $referredDriversCount,
                    'total_earnings_from_challenges' => (float) $totalEarnings,
                    'referral_challenges' => $referralChallenges,
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
     * Get referral challenge completion history
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReferralChallengeHistory(Request $request)
    {
        try {
            $user = Auth::guard('user-api')->user();
            
            $perPage = $request->get('per_page', 15);
            
            // Get completed referral challenges
            $completedChallenges = DB::table('user_challenge_progress')
                ->join('challenges', 'user_challenge_progress.challenge_id', '=', 'challenges.id')
                ->where('user_challenge_progress.user_id', $user->id)
                ->where('challenges.challenge_type', 'referral')
                ->where('user_challenge_progress.is_completed', true)
                ->select(
                    'challenges.title_en',
                    'challenges.title_ar',
                    'challenges.reward_amount',
                    'user_challenge_progress.completed_at',
                    'user_challenge_progress.times_completed'
                )
                ->orderBy('user_challenge_progress.completed_at', 'desc')
                ->paginate($perPage);
            
            $lang = request()->header('Accept-Language', 'en');
            
            $data = $completedChallenges->map(function ($item) use ($lang) {
                return [
                    'title' => $lang === 'ar' ? $item->title_ar : $item->title_en,
                    'reward_amount' => (float) $item->reward_amount,
                    'times_completed' => $item->times_completed,
                    'total_earned' => (float) ($item->reward_amount * $item->times_completed),
                    'completed_at' => $item->completed_at,
                    'formatted_date' => \Carbon\Carbon::parse($item->completed_at)->diffForHumans(),
                ];
            });
            
            return response()->json([
                'status' => true,
                'data' => [
                    'completed_challenges' => $data,
                    'pagination' => [
                        'total' => $completedChallenges->total(),
                        'per_page' => $completedChallenges->perPage(),
                        'current_page' => $completedChallenges->currentPage(),
                        'last_page' => $completedChallenges->lastPage(),
                    ]
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching challenge history',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
}