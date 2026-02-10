<?php

namespace App\Services;

use App\Models\User;
use App\Models\Driver;
use App\Models\ReferralReward;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReferralService
{
    /**
     * Get setting value
     */
    private function getSetting($key, $default = 0)
    {
        return DB::table('settings')->where('key', $key)->value('value') ?? $default;
    }

    /**
     * Process referral when a new user registers
     */
    public function processUserReferral(User $newUser, $referralCode = null)
    {
        if (!$referralCode) {
            return [
                'success' => false,
                'message' => 'No referral code provided'
            ];
        }

        DB::beginTransaction();
        
        try {
            // Check if referral code belongs to a user
            $referrer = User::where('referral_code', $referralCode)->first();
            
            if ($referrer) {
                // Link the new user to the referrer
                $newUser->user_id = $referrer->id;
                $newUser->save();
                
                // Create referral reward tracking
                ReferralReward::create([
                    'referrer_id' => $referrer->id,
                    'referrer_type' => 'user',
                    'referred_id' => $newUser->id,
                    'referred_type' => 'user',
                    'orders_completed' => 0,
                    'reward_paid' => false,
                ]);
                
                \Log::info("User {$newUser->id} registered with referral code from user {$referrer->id}");
                
                DB::commit();
                
                return [
                    'success' => true,
                    'message' => 'Referral processed successfully',
                    'referrer_type' => 'user',
                    'referrer_id' => $referrer->id,
                    'referrer_name' => $referrer->name
                ];
            }
            
            // Check if referral code belongs to a driver
            $referrer = Driver::where('referral_code', $referralCode)->first();
            
            if ($referrer) {
                // Link the new user to the driver referrer
                $newUser->driver_id = $referrer->id;
                $newUser->save();
                
                // Create referral reward tracking
                ReferralReward::create([
                    'referrer_id' => $referrer->id,
                    'referrer_type' => 'driver',
                    'referred_id' => $newUser->id,
                    'referred_type' => 'user',
                    'orders_completed' => 0,
                    'reward_paid' => false,
                ]);
                
                \Log::info("User {$newUser->id} registered with referral code from driver {$referrer->id}");
                
                DB::commit();
                
                return [
                    'success' => true,
                    'message' => 'Referral processed successfully',
                    'referrer_type' => 'driver',
                    'referrer_id' => $referrer->id,
                    'referrer_name' => $referrer->name
                ];
            }
            
            DB::rollBack();
            
            return [
                'success' => false,
                'message' => 'Invalid referral code'
            ];
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error("Error processing user referral: " . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Error processing referral: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Process referral when a new driver registers
     */
    public function processDriverReferral(Driver $newDriver, $referralCode = null)
    {
        if (!$referralCode) {
            return [
                'success' => false,
                'message' => 'No referral code provided'
            ];
        }

        DB::beginTransaction();
        
        try {
            // Check if referral code belongs to a user
            $referrer = User::where('referral_code', $referralCode)->first();
            
            if ($referrer) {
                // Create referral reward tracking (driver referred by user)
                ReferralReward::create([
                    'referrer_id' => $referrer->id,
                    'referrer_type' => 'user',
                    'referred_id' => $newDriver->id,
                    'referred_type' => 'driver',
                    'orders_completed' => 0,
                    'reward_paid' => false,
                ]);
                
                \Log::info("Driver {$newDriver->id} registered with referral code from user {$referrer->id}");
                
                DB::commit();
                
                return [
                    'success' => true,
                    'message' => 'Referral processed successfully',
                    'referrer_type' => 'user',
                    'referrer_id' => $referrer->id,
                    'referrer_name' => $referrer->name
                ];
            }
            
            // Check if referral code belongs to a driver
            $referrer = Driver::where('referral_code', $referralCode)->first();
            
            if ($referrer) {
                // Create referral reward tracking (driver referred by driver)
                ReferralReward::create([
                    'referrer_id' => $referrer->id,
                    'referrer_type' => 'driver',
                    'referred_id' => $newDriver->id,
                    'referred_type' => 'driver',
                    'orders_completed' => 0,
                    'reward_paid' => false,
                ]);
                
                \Log::info("Driver {$newDriver->id} registered with referral code from driver {$referrer->id}");
                
                DB::commit();
                
                return [
                    'success' => true,
                    'message' => 'Referral processed successfully',
                    'referrer_type' => 'driver',
                    'referrer_id' => $referrer->id,
                    'referrer_name' => $referrer->name
                ];
            }
            
            DB::rollBack();
            
            return [
                'success' => false,
                'message' => 'Invalid referral code'
            ];
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error("Error processing driver referral: " . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Error processing referral: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Process reward when referred user/driver completes an order
     * Call this after each order completion
     */
    public function processOrderCompletion($userId)
    {
        try {
            // Find all referral records where this user was referred and reward not yet paid
            $referralRewards = ReferralReward::where('referred_id', $userId)
                ->where('referred_type', 'user')
                ->where('reward_paid', false)
                ->get();
            
            $ordersNeededForReward = $this->getSetting('number_of_order_to_get_reward', 1);
            
            foreach ($referralRewards as $referralReward) {
                // Increment order count
                $referralReward->increment('orders_completed');
                
                \Log::info("Referral reward {$referralReward->id}: Orders completed {$referralReward->orders_completed}/{$ordersNeededForReward}");
                
                // Check if they've reached the threshold
                if ($referralReward->orders_completed >= $ordersNeededForReward) {
                    $this->payReferralReward($referralReward);
                }
            }
            
            return true;
        } catch (\Exception $e) {
            \Log::error("Error processing order completion for referral: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Pay the referral reward
     */
    private function payReferralReward(ReferralReward $referralReward)
    {
        DB::beginTransaction();
        
        try {
            // Determine reward amount based on referred type
            if ($referralReward->referred_type === 'user') {
                $rewardAmount = $this->getSetting('user_referral_user_reward', 0);
            } else {
                $rewardAmount = $this->getSetting('driver_referral_user_reward', 0);
            }
            
            if ($rewardAmount <= 0) {
                \Log::info("Referral reward amount is 0, skipping payment for referral {$referralReward->id}");
                return false;
            }
            
            // Get the referrer
            if ($referralReward->referrer_type === 'user') {
                $referrer = User::find($referralReward->referrer_id);
                
                if ($referrer) {
                    // Add balance to user
                    $referrer->addBalance(
                        $rewardAmount,
                        "Referral reward for referring {$referralReward->referred_type} ID: {$referralReward->referred_id}",
                        null,
                        $referrer->id
                    );
                }
            } else {
                $referrer = Driver::find($referralReward->referrer_id);
                
                if ($referrer) {
                    // Add balance to driver
                    $referrer->addBalance(
                        $rewardAmount,
                        "Referral reward for referring {$referralReward->referred_type} ID: {$referralReward->referred_id}",
                        null,
                        $referrer->id
                    );
                }
            }
            
            // Mark as paid
            $referralReward->update([
                'reward_paid' => true,
                'reward_amount' => $rewardAmount,
                'reward_paid_at' => now(),
            ]);
            
            \Log::info("Referral reward paid: {$rewardAmount} to {$referralReward->referrer_type} ID: {$referralReward->referrer_id}");
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error paying referral reward: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Generate a unique referral code
     */
    public function generateReferralCode($prefix = '')
    {
        do {
            $code = $prefix . strtoupper(Str::random(8));
            
            $existsInUsers = User::where('referral_code', $code)->exists();
            $existsInDrivers = Driver::where('referral_code', $code)->exists();
            
        } while ($existsInUsers || $existsInDrivers);
        
        return $code;
    }
    
    /**
     * Get referral statistics for a user
     */
    public function getUserReferralStats(User $user)
    {
        $referredUsersCount = User::where('user_id', $user->id)->count();
        $referredDriversCount = ReferralReward::where('referrer_id', $user->id)
            ->where('referrer_type', 'user')
            ->where('referred_type', 'driver')
            ->count();
        
        $totalEarnings = ReferralReward::where('referrer_id', $user->id)
            ->where('referrer_type', 'user')
            ->where('reward_paid', true)
            ->sum('reward_amount');
        
        $pendingRewards = ReferralReward::where('referrer_id', $user->id)
            ->where('referrer_type', 'user')
            ->where('reward_paid', false)
            ->count();
        
        return [
            'total_referrals' => $referredUsersCount + $referredDriversCount,
            'referred_users' => $referredUsersCount,
            'referred_drivers' => $referredDriversCount,
            'total_earnings' => (float) $totalEarnings,
            'pending_rewards' => $pendingRewards,
        ];
    }
    
    /**
     * Get referral statistics for a driver
     */
    public function getDriverReferralStats(Driver $driver)
    {
        $referredUsersCount = User::where('driver_id', $driver->id)->count();
        
        $referredDriversCount = ReferralReward::where('referrer_id', $driver->id)
            ->where('referrer_type', 'driver')
            ->where('referred_type', 'driver')
            ->count();
        
        $totalEarnings = ReferralReward::where('referrer_id', $driver->id)
            ->where('referrer_type', 'driver')
            ->where('reward_paid', true)
            ->sum('reward_amount');
        
        $pendingRewards = ReferralReward::where('referrer_id', $driver->id)
            ->where('referrer_type', 'driver')
            ->where('reward_paid', false)
            ->count();
        
        return [
            'total_referrals' => $referredUsersCount + $referredDriversCount,
            'referred_users' => $referredUsersCount,
            'referred_drivers' => $referredDriversCount,
            'total_earnings' => (float) $totalEarnings,
            'pending_rewards' => $pendingRewards,
        ];
    }
    
    /**
     * Get detailed referral list with reward status
     */
    public function getUserReferralList(User $user, $perPage = 15)
    {
        return ReferralReward::where('referrer_id', $user->id)
            ->where('referrer_type', 'user')
            ->with(['referred'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    /**
     * Get detailed referral list for driver
     */
    public function getDriverReferralList(Driver $driver, $perPage = 15)
    {
        return ReferralReward::where('referrer_id', $driver->id)
            ->where('referrer_type', 'driver')
            ->with(['referred'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}