<?php
namespace AporteWeb\Dashboard;

/**
 * SDClapServiceProvider
 *
 * The service provider for the modules. After being registered
 * it will make sure that each of the modules are properly loaded
 * i.e. with their routes, views etc.
 *
 * @author Alfonzo Diez <alfonzodiez@gmail.com>
 * @package AporteWeb\Dashboard
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use AporteWeb\Dashboard\Models\Content;
use AporteWeb\Dashboard\View\Components\Messages;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use AporteWeb\Dashboard\Models\ConfigVar;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Junges\ACL\Models\Permission;


class DashboardServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        // App::register('Krucas\Notification\NotificationServiceProvider');
        // App::alias('Notification','Krucas\Notification\Facades\Notification');
    }
    public function boot()
    {
        Builder::macro('findByPK', function ($args) {
            // $this->wheres
            $condition = Schema::hasColumn($this->from, 'uuid');
            if ($condition) {
                return $this->where('uuid', $args);
            } else {
                return $this->where('id', $args);
            }
        });
        $request = request()->all();
        /*
        foreach ($request as $key => $value) {
            if ($request[$key] == 'undefined' || $request[$key] == 'null' || $request[$key] == 'NULL') {
                $request[$key] = null;
            }
        }
        */
        array_walk_recursive($request, function (&$item, $clave) {
            if ($item == 'undefined' || $item == 'null' || $item == 'NULL') {
                $item = null;
            }
        });
        request()->merge($request);

        \Illuminate\Database\Query\Builder::macro('toRawSql', function(){
            return array_reduce($this->getBindings(), function($sql, $binding){
                return preg_replace('/\?/', is_numeric($binding) ? $binding : "'".$binding."'" , $sql, 1);
            }, $this->toSql());
        });
        \Illuminate\Database\Eloquent\Builder::macro('toRawSql', function(){
            return ($this->getQuery()->toRawSql());
        });
                

        Paginator::useBootstrap();
        Artisan::command('dashboard:init', function () {
            $bar = $this->output->createProgressBar(4);
            $bar->start();
            Artisan::call('key:generate');
            $bar->advance();
            Artisan::call('storage:link');
            $bar->advance();
            Artisan::call('migrate:fresh', [
                '--seed' => true
            ]);
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
        Artisan::command('dashboard:crudeame', function () {
            $bar = $this->output->createProgressBar(2);
            $bar->start();
            $bar->advance();
            Artisan::call('migrate:refresh --path=vendor/aporteweb/dashboard/src/migrations/2020_11_23_000001_generate_crud_tables.php');
            $bar->advance();
            $bar->finish();
            $this->info("\nSe actualizaron las tablas del CRUD");
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
        
        // hasAnyPermission
        Blade::directive('hap', function ($permissions) {
            $ps = explode(',', str_replace('\'', '', $permissions));
            foreach ($ps as $p) {
                $i = Permission::firstOrCreate(
                    ['slug' => $p],
                    ['name' => $p, 'description' => 'this permission was autogenerated by the system']
                );
            }
            return "<?php if(auth()->check() && auth()->user()->hasAnyPermission({$permissions})){ ?>";
        });
        Blade::directive('endhap', function () {
            return '<?php } ?>';
        });
        // end hasAnyPermission

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
        if(file_exists(__DIR__.'/routes/web.php')) {
            Route::middleware('web')
                ->namespace('\AporteWeb\Dashboard\Controllers')
                ->group(__DIR__.'/routes/web.php');
        }
        if(file_exists(__DIR__.'/routes/breadcrumbs.php')) {
            include __DIR__.'/routes/breadcrumbs.php';
        }
        // Load the views
        if(is_dir(__DIR__.'/resources/views')) {
            $this->loadViewsFrom(__DIR__.'/resources/views', 'Dashboard');
        }
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
        config(['admin.text.footer' => 'Todos los derechos reservados © Dashboard 2019']);
        view()->share([
            '__admin_active' => 'admin',
        ]);
        view()->composer('*', function ($view)
        {
            //...with this variable
            // $view->with('__admin_menu', 'Dashboard::admin.menu');
        });
    }
}
