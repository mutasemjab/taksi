<?php

namespace App\Http\Controllers\Api\v1\Driver;

use App\Http\Controllers\Controller;
use App\Models\CardNumber;
use App\Models\CardUsage;
use App\Models\WalletTransaction;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



class WalletDriverController extends Controller
{
    use Responses;
  
    public function getTransactions(Request $request)
    {
        $driver = Auth::guard('driver-api')->user();
        
        $validator = Validator::make($request->all(), [
            'type' => 'sometimes|in:1,2', // 1 for add, 2 for withdrawal
            'per_page' => 'sometimes|integer|min:5|max:100',
            'sort_by' => 'sometimes|in:date,amount',
            'sort_direction' => 'sometimes|in:asc,desc'
        ]);
        
        if ($validator->fails()) {
            return $this->error_response('Validation error', $validator->errors());
        }
        
        $query = WalletTransaction::where('driver_id', $driver->id);
        
        // Filter by transaction type if provided
        if ($request->has('type')) {
            $query->where('type_of_transaction', $request->type);
        }
        
        // Apply sorting
        $sortBy = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        
        if ($sortBy === 'date') {
            $sortBy = 'created_at';
        }
        
        $query->orderBy($sortBy, $sortDirection);
        
        // Pagination
        $perPage = $request->per_page ?? 15;
        $transactions = $query->paginate($perPage);
        
        $responseData = [
            'balance' => $driver->balance,
            'transactions' => $transactions,
            'meta' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total()
            ]
        ];
        
        return $this->success_response('Driver wallet transactions retrieved successfully', $responseData);
    }

public function useCard(Request $request)
    {
        \Log::info('useCard method called', ['request_data' => $request->all()]);
        
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            \Log::warning('useCard validation failed', ['errors' => $validator->errors()]);
            return $this->error_response($validator->errors(),[]);
        }

        // Get authenticated driver
        $driver = Auth::guard('driver-api')->user();
        if (!$driver) {
            \Log::error('useCard: Driver not authenticated');
            return $this->error_response(__('messages.driver_not_authenticated'),[]);
        }

        \Log::info('useCard: Driver authenticated', ['driver_id' => $driver->id, 'driver_name' => $driver->name]);

        DB::beginTransaction();

        try {
            // Remove formatting from card number (remove dashes)
            $cardNumberClean = str_replace('-', '', $request->card_number);
            \Log::info('useCard: Card number cleaned', ['original' => $request->card_number, 'cleaned' => $cardNumberClean]);
            
            // Find the card number
            $cardNumber = CardNumber::where('number', $cardNumberClean)->first();
            
            if (!$cardNumber) {
                \Log::error('useCard: Card number not found', ['card_number' => $cardNumberClean]);
                return $this->error_response(__('messages.invalid_card_number'),[]);
            }

            \Log::info('useCard: Card number found', ['card_number_id' => $cardNumber->id, 'status' => $cardNumber->status, 'activate' => $cardNumber->activate]);

            // Check if card number is active
            if ($cardNumber->activate != CardNumber::ACTIVATE_ACTIVE) {
                \Log::warning('useCard: Card number is inactive', ['card_number_id' => $cardNumber->id, 'activate_status' => $cardNumber->activate]);
                return $this->error_response(__('messages.card_number_inactive'),[]);
            }

            // Check if card number is already used
            if ($cardNumber->status == CardNumber::STATUS_USED) {
                \Log::warning('useCard: Card number already used', ['card_number_id' => $cardNumber->id]);
                return $this->error_response(__('messages.card_number_already_used'),[]);
            }

            // Get the card details
            $card = $cardNumber->card;
            if (!$card) {
                \Log::error('useCard: Card not found for card number', ['card_number_id' => $cardNumber->id]);
                return $this->error_response(__('messages.card_not_found'),[]);
            }

            \Log::info('useCard: Card found', ['card_id' => $card->id, 'card_name' => $card->name, 'card_price' => $card->price]);

            // Add balance to driver wallet
            \Log::info('useCard: Adding balance to driver wallet', ['driver_id' => $driver->id, 'amount' => $card->price]);
            $walletTransaction = $driver->addBalance(
                $card->price,
                __('messages.card_usage_note', ['card_name' => $card->name, 'card_number' => $request->card_number])
            );
            \Log::info('useCard: Balance added successfully', ['transaction_id' => $walletTransaction->id]);

            // Mark card number as used
            $cardNumber->update(['status' => CardNumber::STATUS_USED]);
            \Log::info('useCard: Card number marked as used', ['card_number_id' => $cardNumber->id]);

            // Record card usage
            $cardUsage = CardUsage::create([
                'driver_id' => $driver->id,
                'card_number_id' => $cardNumber->id,
                'wallet_transaction_id' => $walletTransaction->id,
                'used_at' => now(),
            ]);
            \Log::info('useCard: Card usage recorded', ['card_usage_id' => $cardUsage->id]);

            DB::commit();
            \Log::info('useCard: Transaction committed successfully');

            // Prepare response data
            $responseData = [
                'driver' => [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'balance' => $driver->fresh()->formatted_balance,
                    'previous_balance' => number_format($driver->balance - $card->price, 2),
                ],
                'card' => [
                    'id' => $card->id,
                    'name' => $card->name,
                    'price' => number_format($card->price, 2),
                    'pos' => $card->pos ? $card->pos->name : null,
                ],
                'card_number' => [
                    'id' => $cardNumber->id,
                    'number' => $request->card_number,
                    'formatted_number' => $cardNumber->formatted_number,
                ],
                'transaction' => [
                    'id' => $walletTransaction->id,
                    'amount' => $walletTransaction->formatted_amount,
                    'type' => $walletTransaction->type_text,
                    'note' => $walletTransaction->note,
                    'created_at' => $walletTransaction->created_at->format('Y-m-d H:i:s'),
                ],
                'usage' => [
                    'id' => $cardUsage->id,
                    'used_at' => $cardUsage->used_at->format('Y-m-d H:i:s'),
                    'location' => $cardUsage->location,
                ]
            ];

            \Log::info('useCard: Success response prepared', ['driver_id' => $driver->id, 'card_id' => $card->id]);
            return $this->success_response(
                __('messages.card_used_successfully'),
                $responseData
            );

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('useCard: Exception occurred', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
                'driver_id' => $driver ? $driver->id : null,
                'card_number' => $request->card_number
            ]);
            return $this->error_response(__('messages.error_using_card') . ': ' . $e->getMessage(),[]);
        }
    }

     public function addBalance(Request $request)
    {
        \Log::info('addBalance method called', ['request_data' => $request->all()]);
        
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01|max:10000',
        ]);

        if ($validator->fails()) {
            \Log::warning('addBalance validation failed', ['errors' => $validator->errors()]);
            return $this->error_response($validator->errors(),[]);
        }

        // Get authenticated driver from token
        $driver = Auth::guard('driver-api')->user();
        if (!$driver) {
            \Log::error('addBalance: Driver not authenticated');
            return $this->error_response(__('messages.driver_not_authenticated'),[]);
        }

        \Log::info('addBalance: Driver authenticated', ['driver_id' => $driver->id, 'driver_name' => $driver->name]);

        DB::beginTransaction();

        try {
            $amount = $request->amount;
            $previousBalance = $driver->balance;
            
            \Log::info('addBalance: Starting balance addition', [
                'driver_id' => $driver->id,
                'amount_to_add' => $amount,
                'previous_balance' => $previousBalance
            ]);

            // Add balance to driver wallet
            $walletTransaction = $driver->addBalance(
                $amount,
                __('messages.balance_added_via_api')
            );
            
            \Log::info('addBalance: Balance added successfully', ['transaction_id' => $walletTransaction->id]);

            DB::commit();
            \Log::info('addBalance: Transaction committed successfully');

            // Prepare response data
            $responseData = [
                'driver' => [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'phone' => $driver->full_phone,
                    'previous_balance' => number_format($previousBalance, 2),
                    'current_balance' => $driver->fresh()->formatted_balance,
                    'added_amount' => number_format($amount, 2),
                ],
                'transaction' => [
                    'id' => $walletTransaction->id,
                    'amount' => $walletTransaction->formatted_amount,
                    'type' => $walletTransaction->type_text,
                    'note' => $walletTransaction->note,
                    'created_at' => $walletTransaction->created_at->format('Y-m-d H:i:s'),
                ]
            ];

            \Log::info('addBalance: Success response prepared', ['driver_id' => $driver->id, 'amount_added' => $amount]);
            return $this->success_response(
                __('messages.balance_added_successfully'),
                $responseData
            );

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('addBalance: Exception occurred', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
                'driver_id' => $driver ? $driver->id : null,
                'amount' => $request->amount
            ]);
            return $this->error_response(__('messages.error_adding_balance') . ': ' . $e->getMessage(),[]);
        }
    }
}