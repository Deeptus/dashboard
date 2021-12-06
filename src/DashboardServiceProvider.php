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
use AporteWeb\Dashboard\View\Components\SidebarMenu;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use AporteWeb\Dashboard\Models\ConfigVar;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Junges\ACL\Models\Permission;
use Illuminate\Support\Facades\Storage;

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
            $actions = $this->select(
                "\nSelect options",
                [
                  0 => 'key:generate',
                  1 => 'storage:link',
                  2 => 'migrate:fresh',
                  3 => 'Create default admin user',
                  4 => 'Install package.json',
                  5 => 'Website basic scaffolding',
                  6 => 'Admin basic scaffolding',
                  7 => 'Website client scaffolding',
                ]
            );
            $bar = $this->output->createProgressBar(count($actions));

            $bar->start();
            // get content package.json file
            if (in_array('Install package.json', $actions)) {
                $path = base_path('package.json');
                $package = json_decode(file_get_contents($path));
                $package->devDependencies = new \stdClass();
                $package->dependencies = [
                    "aporteweb-dashboard" => "file:../packages/aporteweb/dashboard-js",
                    "animate.css" => "^4.1.1",
                    "aos" => "^3.0.0-beta.6",        
                ];
                // put content package.json file
                file_put_contents($path, json_encode($package, JSON_PRETTY_PRINT));
                $bar->advance();
            }
            if (in_array('Website basic scaffolding', $actions) || in_array('Admin basic scaffolding', $actions)) {
                $paths = [
                    __DIR__ . '/Generators/templates/resources/js/bootstrap.js' => resource_path('js/bootstrap.js'),
                    __DIR__ . '/Generators/templates/resources/js/dashboard.js' => resource_path('js/dashboard.js'),
                    __DIR__ . '/Generators/templates/resources/js/website.js' => resource_path('js/website.js'),
                    __DIR__ . '/Generators/templates/resources/js/components/admin/.keep' => resource_path('js/components/admin/.keep'),
                    __DIR__ . '/Generators/templates/resources/js/components/website/.keep' => resource_path('js/components/website/.keep'),
                    __DIR__ . '/Generators/templates/resources/sass/_variables.scss' => resource_path('sass/_variables.scss'),
                    __DIR__ . '/Generators/templates/resources/sass/dashboard.scss' => resource_path('sass/dashboard.scss'),
                    __DIR__ . '/Generators/templates/resources/sass/website.scss' => resource_path('sass/website.scss'),
                    __DIR__ . '/Generators/templates/resources/sass/website.scss' => resource_path('sass/website.scss'),
                    __DIR__ . '/Generators/templates/resources/sass/components/.keep' => resource_path('sass/components/.keep'),
                    __DIR__ . '/Generators/templates/resources/sass/sections/.keep' => resource_path('sass/sections/.keep'),
                    __DIR__ . '/Generators/templates/webpack.mix.js' => base_path('webpack.mix.js'),
                    __DIR__ . '/Generators/templates/AppServiceProvider.php' => app_path('Providers/AppServiceProvider.php'),
                    __DIR__ . '/Generators/templates/RouteServiceProvider.php' => app_path('Providers/RouteServiceProvider.php'),
                    __DIR__ . '/Generators/templates/config/acl.php' => config_path('acl.php'),
                    __DIR__ . '/Generators/templates/config/auth.php' => config_path('auth.php'),
                    __DIR__ . '/Generators/templates/config/laravellocalization.php' => config_path('laravellocalization.php'),
                    __DIR__ . '/Generators/templates/config/translatable.php' => config_path('translatable.php'),
                    __DIR__ . '/Generators/templates/Middleware/RedirectIfAuthenticatedClient.php' => app_path('Http/Middleware/RedirectIfAuthenticatedClient.php'),
                ];
                foreach ($paths as $path => $destination) {
                    if (!file_exists(dirname($destination))) {
                        mkdir(dirname($destination), 0777, true);
                    }
                    copy($path, $destination);
                }

                $replacing = [
                    config_path('app.php') => [
                        "'locale' => 'en'" => "'locale' => 'es'",
                        "'fallback_locale' => 'en'" => "'fallback_locale' => 'es'",
                        "'faker_locale' => 'en_US'" => "'faker_locale' => 'es_ES'",
                    ]
                ];
                foreach ($replacing as $path => $replacements) {
                    $content = file_get_contents($path);
                    foreach ($replacements as $search => $replace) {
                        $content = str_replace($search, $replace, $content);
                    }
                    file_put_contents($path, $content);
                }
                // Copy folder
                // I am observation you have to try it in windows
                shell_exec("cp -r " . __DIR__ . "/Generators/templates/Controllers " . app_path('Http'));
                shell_exec("cp -r " . __DIR__ . "/Generators/templates/Models " . app_path('/'));
                shell_exec("cp -r " . __DIR__ . "/Generators/templates/Dashboard " . app_path('/'));
                shell_exec("cp -r " . __DIR__ . "/Generators/templates/resources/views " . resource_path('/'));
                shell_exec("cp -r " . __DIR__ . "/Generators/templates/public/* " . public_path('/'));
                shell_exec("cp -r " . __DIR__ . "/Generators/templates/routes " . base_path('/'));
                shell_exec("chmod -R 777 " . base_path('/'));
                file_put_contents(base_path('/routes/admin.php'), '<?php');
                file_put_contents(base_path('/routes/client.php'), '<?php');
                $bar->advance();
            }


            if (in_array('key:generate', $actions)) {
                Artisan::call('key:generate');
                $bar->advance();
            }
            if (in_array('storage:link', $actions)) {
                Artisan::call('storage:link');
                $bar->advance();
            }
            if (in_array('migrate:fresh', $actions)) {
                Artisan::call('migrate:fresh', [
                    '--seed' => true
                ]);
                $bar->advance();
            }
            if (in_array('Create default admin user', $actions)) {
                DB::table('users')->insert([
                    'uuid'     => __uuid(),
                    'name'     => 'Administrador',
                    'username' => 'admin',
                    'email'    => 'admin@local.test',
                    'password' => bcrypt('admin'),
                    'root'     => 1,
                ]);
                $bar->advance();
            }
            if (in_array('Website client scaffolding', $actions)) {
                $path = app_path('Http/Kernel.php');
                $content = file_get_contents($path);
                $content = str_replace("'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class", "'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,\n\t\t'client' => \App\Http\Middleware\RedirectIfAuthenticatedClient::class", $content);
                file_put_contents($path, $content);
            }

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
        Blade::component('sidebar-menu', SidebarMenu::class);
        
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
        config(['admin.text.footer' => 'Todos los derechos reservados']);
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
