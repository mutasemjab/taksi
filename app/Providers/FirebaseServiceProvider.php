<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Firestore;

class FirebaseServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        $this->app->singleton(Firestore::class, function ($app) {
            $credentialsPath = config('firebase.credentials.file');

            if (!$credentialsPath || !file_exists(base_path($credentialsPath))) {
                throw new \Exception("Firebase credentials file not found at: $credentialsPath");
            }

            // ✅ Extract project ID from credentials file
            $credentials = json_decode(file_get_contents(base_path($credentialsPath)), true);
            $projectId = $credentials['project_id'] ?? config('firebase.project_id');

            return (new Factory)
                ->withServiceAccount(base_path($credentialsPath))
                ->withProjectId($projectId)  // ✅ ADD THIS LINE
                ->createFirestore();
        });
    }

    public function boot(): void
    {
        //
    }
}