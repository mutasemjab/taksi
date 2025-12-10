<?php


namespace App\Http\Controllers\Api\v1\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverService;
use App\Models\Service;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ServiceDriverController extends Controller
{
    use Responses;

    public function index(Request $request)
    {
        // Get all active services
        $services = Service::where('activate', 1)->with('servicePayments')->get();
        
        // Check if a driver is authenticated
        $driver = auth('driver-api')->user();
        
        if ($driver) {
            // Get the driver's services with their types and statuses
            $driverServices = DriverService::where('driver_id', $driver->id)
                ->get()
                ->keyBy('service_id');
            
            // Map services with their status for this driver
            $services = $services->map(function($service) use ($driverServices) {
                if (isset($driverServices[$service->id])) {
                    $driverService = $driverServices[$service->id];
                    
                    // Service is assigned to driver
                    $service->is_available = true;
                    $service->service_type = $driverService->service_type; // 1 = primary, 2 = optional
                    $service->driver_status = $driverService->status; // 1 = active, 2 = inactive
                    
                    // Determine if driver can toggle this service
                    if ($driverService->service_type == 1) {
                        // Primary service - cannot be toggled off
                        $service->can_toggle = false;
                        $service->service_type_label = 'primary';
                        $service->service_type_label_ar = 'أساسية';
                    } else {
                        // Optional service - can be toggled
                        $service->can_toggle = true;
                        $service->service_type_label = 'optional';
                        $service->service_type_label_ar = 'اختيارية';
                    }
                } else {
                    // Service is not assigned to this driver - unavailable
                    $service->is_available = false;
                    $service->service_type = null;
                    $service->driver_status = 2; // Show as inactive
                    $service->can_toggle = false;
                    $service->service_type_label = 'unavailable';
                    $service->service_type_label_ar = 'غير متاحة';
                }
                
                return $service;
            });
            
            // Optionally, separate services by type for easier UI handling
            $response = [
                'all_services' => $services,
                'primary_services' => $services->filter(function($service) {
                    return isset($service->service_type) && $service->service_type == 1;
                })->values(),
                'optional_services' => $services->filter(function($service) {
                    return isset($service->service_type) && $service->service_type == 2;
                })->values(),
                'unavailable_services' => $services->filter(function($service) {
                    return !$service->is_available;
                })->values(),
            ];
            
            return $this->success_response('Services retrieved successfully', $response);
        }
        
        // If no driver is authenticated, return all services without status
        return $this->success_response('Services retrieved successfully', $services);
    }

    public function storeOrUpdateStatus(Request $request)
    {
        $driver_id = auth()->guard('driver-api')->user()->id;
        
        // Validate request
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'status' => 'required|in:1,2', // 1 active, 2 inactive
        ]);

        if ($validator->fails()) {
            return $this->error_response(__('messages.Validation_error'), $validator->errors());
        }

        // Check if the service is assigned to this driver
        $driverService = DriverService::where('driver_id', $driver_id)
            ->where('service_id', $request->service_id)
            ->first();

        if (!$driverService) {
            // Service is not available for this driver
            return $this->error_response(__('messages.Service_not_available'), null, 403);
        }

        // Check if it's a primary service (service_type = 1)
        if ($driverService->service_type == 1) {
            // Primary service cannot be disabled
            if ($request->status == 2) {
                return $this->error_response(__('messages.Cannot_disable_primary_service'), null, 403);
            }
            
            // If trying to enable primary service (which should already be active)
            return $this->success_response(__('messages.Primary_service_is_always_active'), $driverService);
        }

        // Check if it's an optional service (service_type = 2)
        if ($driverService->service_type == 2) {
            // Update the status
            $driverService->status = $request->status;
            $driverService->save();
            
            $statusText = $request->status == 1 ? __('messages.activated') : __('messages.deactivated');
            $message = __('messages.Service') . ' ' . $statusText . ' ' . __('messages.successfully');
            
            return $this->success_response($message, $driverService);
        }

        // This shouldn't happen, but just in case
        return $this->error_response(__('messages.Invalid_service_type'), null, 400);
    }
}
