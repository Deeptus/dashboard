<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\CompanyData;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        if (env('FORCE_HTTPS') == true) {
            \URL::forceScheme('https');
        }
        if (config('app.debug')){
            $assets_version = hash('md5', rand());
        } else {
            $assets_version = '1';
        }
        if (php_sapi_name() != 'cli') {
            // $companyData = CompanyData::first();
            // Config::set('companyData', $companyData);
            // dd($companyData);
            $client = auth()->guard('client');
            view()->share([
                // 'companyData'    => $companyData,
                'active'         => '',
                'assets_version' => $assets_version,
                'privatezone'    => $client
            ]);
        }

    }
}
