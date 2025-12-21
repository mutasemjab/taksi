<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Firestore;
use App\Models\Driver;

class DriverMapController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        // Lazy load Firestore
    }

    private function getFirestore()
    {
        if (!$this->firestore) {
            $this->firestore = app(Firestore::class);
        }
        return $this->firestore;
    }

    /**
     * Display the driver locations map
     */
    public function index()
    {
        return view('admin.drivers.map');
    }

    /**
     * Get all driver locations from Firebase
     */
    public function getDriverLocations(Request $request)
    {
        try {
            $firestore = $this->getFirestore();
            $driversCollection = $firestore->database()->collection('drivers');
            
            // Get all driver documents
            $documents = $driversCollection->documents();
            
            $driverLocations = [];
            
            foreach ($documents as $document) {
                if ($document->exists()) {
                    $data = $document->data();
                    $driverId = $document->id();
                    
                    // Get driver info from MySQL
                    $driver = Driver::find($driverId);
                    
                    // Check if location data exists and is valid
                    if (isset($data['lat']) && isset($data['lng']) && 
                        !empty($data['lat']) && !empty($data['lng']) && $driver) {
                        
                        $driverLocations[] = [
                            'id' => $driverId,
                            'name' => $driver->name ?? 'Driver #' . $driverId,
                            'phone' => $driver->phone ?? '',
                            'status' => $driver->status == 1 ? 'online' : 'offline',
                            'activate' => $driver->activate == 1,
                            'balance' => $driver->balance ?? 0,
                            'lat' => (float)$data['lat'],
                            'lng' => (float)$data['lng'],
                            'last_updated' => $data['updated_at'] ?? now()->toISOString(),
                        ];
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'drivers' => $driverLocations,
                'total' => count($driverLocations),
                'timestamp' => now()->toISOString()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching driver locations from Firebase: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching driver locations: ' . $e->getMessage(),
                'drivers' => [],
                'total' => 0
            ], 500);
        }
    }

    /**
     * Get location for a specific driver
     */
    public function getDriverLocation($driverId)
    {
        try {
            $firestore = $this->getFirestore();
            $document = $firestore->database()
                ->collection('drivers')
                ->document((string)$driverId)
                ->snapshot();
            
            if (!$document->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Driver location not found in Firebase'
                ], 404);
            }
            
            $data = $document->data();
            $driver = Driver::find($driverId);
            
            if (!$driver) {
                return response()->json([
                    'success' => false,
                    'message' => 'Driver not found in database'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'driver' => [
                    'id' => $driverId,
                    'name' => $driver->name,
                    'phone' => $driver->phone,
                    'status' => $driver->status == 1 ? 'online' : 'offline',
                    'lat' => (float)$data['lat'],
                    'lng' => (float)$data['lng'],
                    'last_updated' => $data['updated_at'] ?? now()->toISOString(),
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching driver location: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching driver location: ' . $e->getMessage()
            ], 500);
        }
    }
}