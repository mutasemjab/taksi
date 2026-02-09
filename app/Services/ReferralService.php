<?php

namespace App\Services;

use App\Models\User;
use App\Models\Driver;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReferralService
{
    /**
     * Process referral when a new user registers
     * 
     * @param User $newUser The newly registered user
     * @param string|null $referralCode The referral code used during registration
     * @return array Result of the referral process
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
                
                // Update referral challenge progress (rewards handled by Challenge system)
                $referrer->updateChallengeProgress('referral', 1);
                
                \Log::info("User {$newUser->id} registered with referral code from user {$referrer->id}. Challenge progress updated.");
                
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
     * 
     * @param Driver $newDriver The newly registered driver
     * @param string|null $referralCode The referral code used during registration
     * @return array Result of the referral process
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
                // Link the new driver to the user referrer
                $newDriver->user_id = $referrer->id;
                $newDriver->save();
                
                // Update referral challenge progress (rewards handled by Challenge system)
                $referrer->updateChallengeProgress('referral', 1);
                
                \Log::info("Driver {$newDriver->id} registered with referral code from user {$referrer->id}. Challenge progress updated.");
                
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
                // Link the new driver to the driver referrer
                $newDriver->driver_id = $referrer->id;
                $newDriver->save();
                
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
     * Generate a unique referral code
     * 
     * @param string $prefix Prefix for the referral code (e.g., 'USER', 'DRIVER')
     * @return string Unique referral code
     */
    public function generateReferralCode($prefix = '')
    {
        do {
            $code = $prefix . strtoupper(Str::random(8));
            
            // Check if code exists in users or drivers table
            $existsInUsers = User::where('referral_code', $code)->exists();
            $existsInDrivers = Driver::where('referral_code', $code)->exists();
            
        } while ($existsInUsers || $existsInDrivers);
        
        return $code;
    }
    
    /**
     * Get referral statistics for a user
     * 
     * @param User $user
     * @return array Statistics about referrals
     */
    public function getUserReferralStats(User $user)
    {
        $referredUsersCount = User::where('user_id', $user->id)->count();
        $referredDriversCount = Driver::where('user_id', $user->id)->count();
        
        $totalEarnings = WalletTransaction::where('user_id', $user->id)
            ->where('type_of_transaction', 1)
            ->where('note', 'LIKE', '%referral%')
            ->sum('amount');
        
        return [
            'total_referrals' => $referredUsersCount + $referredDriversCount,
            'referred_users' => $referredUsersCount,
            'referred_drivers' => $referredDriversCount,
            'total_earnings' => (float) $totalEarnings,
        ];
    }
    
    /**
     * Get referral statistics for a driver
     * 
     * @param Driver $driver
     * @return array Statistics about referrals
     */
    public function getDriverReferralStats(Driver $driver)
    {
        $referredUsersCount = User::where('driver_id', $driver->id)->count();
        $referredDriversCount = Driver::where('driver_id', $driver->id)->count();
        
        $totalEarnings = WalletTransaction::where('driver_id', $driver->id)
            ->where('type_of_transaction', 1)
            ->where('note', 'LIKE', '%referral%')
            ->sum('amount');
        
        return [
            'total_referrals' => $referredUsersCount + $referredDriversCount,
            'referred_users' => $referredUsersCount,
            'referred_drivers' => $referredDriversCount,
            'total_earnings' => (float) $totalEarnings,
        ];
    }
}