<?php

namespace Infoamin\Installer\Http\Controllers;

use AppController;
use Artisan;
use Infoamin\Installer\Repositories\EnvironmentRepository;
use Exception;
use Illuminate\Http\Request;

class DatabaseController extends AppController
{
    /**
     * Show form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $host     = env('DB_HOST');
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        return view('vendor.installer.database', compact('host', 'database', 'username', 'password'));
    }

    /**
     * Manage form submission.
     *
     * @param  Illuminate\Http\Request                               $request
     * @param  Infoamin\Installer\Repositories\EnvironmentRepository $environmentRepository
     * @return redirection
     */
    public function store(Request $request, EnvironmentRepository $environmentRepository)
    {
        //dd($request);
        // Set config for migrations and seeds
        $connection = config('database.default');
        config([
            'database.connections.' . $connection . '.host'     => $request->host,
            'database.connections.' . $connection . '.database' => $request->dbname,
            'database.connections.' . $connection . '.password' => $request->password,
            'database.connections.' . $connection . '.username' => $request->username,
        ]);

        // Update .env file
        $environmentRepository->SetDatabaseSetting($request);
        
        $seedType = "dummy-data-off";

        if (isset($request->seedtype) && $request->seedtype == "on") {
            $seedType = "dummy-data-on";
        }

        return redirect('install/seedmigrate/' . $seedType);
    }

    public function seedMigrate($type)
    {
        // Migrations and seeds
        try {
            ini_set('max_execution_time', 300);
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            if (isset($type) && $type == "dummy-data-on") {
                Artisan::call('migrate');
                Artisan::call('db:seed');
            } else {
                Artisan::call('migrate');
                Artisan::call('db:seed', ['--class' => 'Seeds\\ProductSeeds\\DatabaseSeeder']);
            }

            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        catch (Exception $e)
        {
            $data['error'] = $e;
            \Log::error($e);
            return view('vendor.installer.database-error', $data);
        }

        if (config('installer.administrator'))
        {
            return redirect('install/register');
        }

        return redirect('install/finish');
    }

}
