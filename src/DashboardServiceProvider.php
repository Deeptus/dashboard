<?php

namespace AporteWeb\Dashboard;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\ServiceProvider;

use AporteWeb\Dashboard\Models\ConfigVar;
use AporteWeb\Dashboard\Models\Content;
use AporteWeb\Dashboard\View\Components\Messages;
use AporteWeb\Dashboard\Dashboard;

class DashboardServiceProvider extends ServiceProvider
{


    public function register()
    {

        $this->mergeConfigFrom(__DIR__.'/../config/dashboard.php', 'Dashboard');

    }

    public function boot()
    {

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'Dashboard');
        $this->configurePublishing();
        $this->configureRoutes();

        Paginator::useBootstrap();
        Artisan::command('dashboard:init', function () {



            $bar = $this->output->createProgressBar(4);
            $bar->start();
            Artisan::call('key:generate');
            $bar->advance();
            Artisan::call('storage:link');
            $bar->advance();
            /*Artisan::call('migrate:fresh', [
                '--seed' => true
            ]);*/
            $bar->advance();
            DB::table('users')->insert([
                'uuid'     => __uuid(),
                'name'     => 'Administrador',
                'username' => 'admin',
                'email'    => 'admin@local.test',
                'password' => bcrypt('admin'),
                'root'     => 1,
            ]);
            $bar->advance();
            $bar->finish();
            $this->info("\nSe ejecutaron las migraciones, seeders y se creo el usuario admin!");
        });
        Artisan::command('dashboard:permissions', function () {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table('permissions')->truncate();
            DB::table('permissions')->insert(config('permissions'));
            DB::statement('SET FOREIGN_KEY_CHECKS=1');    
            $this->info("\nSe actualizo el listado de permisos!");
        });

        if (env('FORCE_HTTPS') == true) {
            \URL::forceScheme('https');
        }
        Collection::macro('slug', function () {
            return $this->map(function ($value) {
                return Str::slug($value);
            });
        });
        if (config('app.debug')){
            $assets_version = hash('md5', rand());
        } else {
            $assets_version = '11';
            $path_file = base_path('.git/refs/heads/master');
            if (file_exists($path_file)) {
                // $assets_version = trim(exec('git log --pretty="%h" -n1 HEAD'));
                $assets_version = trim(substr(file_get_contents($path_file), 4));
            }
        }

        if (php_sapi_name() != 'cli') {
            view()->share([
                'assets_version' => $assets_version,
                'query_search'  => ''
            ]);

            view()->composer('*', function ($view) {
                $view->with('__admin_menu', 'admin.menu');
                $view->with('admin_default_image', asset('images/no-image.png'));
            });
        }
        /*
        example
        @exception
            code ......
        @catch
            {!! $e->getMessage() !!}
        @endexception
        */
        // Temporal hasta que se adapten los component a tags a Laravel 7
        /*if (version_compare(App::VERSION(), '7.0.0') >= 0) {
            Blade::withoutComponentTags();
        }*/
        config([
            'log-viewer.theme'         => 'bootstrap-4',
            'log-viewer.route.enabled' => false
        ]);
        Blade::component('dashboard-messages', Messages::class);
        Blade::directive('exception', function () {
            return '<?php try { ?>';
        });

        Blade::directive('catch', function () {
            return '<?php } catch (\Exception $e) { ?>';
            // use {!! $e->getMessage() !!}
        });

        Blade::directive('endexception', function () {
            return '<?php } ?>';
        });
        // Load Routes
        /*if(file_exists(__DIR__.'/routes/web.php')) {
            Route::middleware('web')
                ->namespace('\AporteWeb\Dashboard\Controllers')
                ->group(__DIR__.'/routes/web.php');
        }*/
        /*if(file_exists(__DIR__.'/routes/breadcrumbs.php')) {
            include __DIR__.'/routes/breadcrumbs.php';
        }*/
        // Load the views
       /* if(is_dir(__DIR__.'/resources/views')) {
            $this->loadViewsFrom(__DIR__.'/resources/views', 'Dashboard');
        }*/
        // Load Translations
        if(is_dir(__DIR__.'/resources/lang')) {
            $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'Dashboard');
            // $this->publishes([
            //     __DIR__.'/lang' => resource_path('lang/vendor/aporteweb/dashboard'),
            // ]);
        }
        // Load Migrations
        if(is_dir(__DIR__.'/migrations')) {
            $this->loadMigrationsFrom(__DIR__.'/migrations');
        }
        global $__seeders;
        $seed = [];
        if (is_array($__seeders)) {
            array_merge($__seeders, $seed);
        } else {
            $__seeders = $seed;
        }
        /*
        if(file_exists(__DIR__.'/config/dynamic-content.php')) {
            config(['dynamic-content' => include __DIR__.'/config/dynamic-content.php']);
        }
        if(file_exists(__DIR__.'/config/seo.php')) {
            config(['seo' => include __DIR__.'/config/seo.php']);
        }
        */
        /*
        resolver este bug
        if(file_exists(__DIR__.'/config/permissions.php')) {
            config(['permissions' => include __DIR__.'/config/permissions.php']);
        }
        */
        config(['admin.theme.styles' => 'css/dashboard.css']);
        config(['admin.text.footer' => 'Todos los derechos reservados © Dashboard 2020']);
        view()->share([
            '__admin_active' => 'admin',
        ]);
        view()->composer('*', function ($view)
        {
            //...with this variable
            // $view->with('__admin_menu', 'Dashboard::admin.menu');
        });
    }


    protected function configurePublishing()
    {


        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/dashboard.php' => config_path('dashboard.php'),
        ], 'dashboard');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/dashboard'),
        ], 'dashboard');


    }

    protected function configureRoutes()
    {


        if (Dashboard::$registersRoutes) {
            Route::middleware('web')
                ->namespace('\AporteWeb\Dashboard\Http\Controllers')
                ->group(__DIR__.'/../routes/web.php');
        }

    }


}
