<?php
// Esto hay que probarlo con detalle
if (!function_exists('fastcgi_finish_request')) {
    function fastcgi_finish_request()
    {
        try {
            ob_end_flush();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

if (!function_exists('__file_url')) {
    function __file_url($path, $default_file, $is_storage = false)
    {
        $final = $default_file;
        if ($is_storage != false) {
            if(Storage::exists($path)){
                $final = asset(Storage::url($path));
            }
        } else {
            if(file_exists(public_path($path))){
                $final = asset(Storage::url($path));
            }
        }
        return $final;
    }
}

if (!function_exists('__t')) {
    function __t($key) {

        $data = Cache::remember('seo', env('CACHE_DURATION', 0), function () {
            return \AporteWeb\Dashboard\Models\Translation::get();
        });
        if ($data) {
            $data = $data->where('key', $key)->first();
            if ($data && $data->translation != '') {
                return $data->translation;
            }
        }
        return $key;
    }
}
if (!function_exists('__active')) {
    function __active($var, $active, $class = 'active')
    {
        if ($var == $active) {
            return $class;
        }
        return '';
    }
}
if (!function_exists('display_price')) {
    function display_price($price)
    {
        if ($price!="") {
            return number_format($price, 2, ',', '.');
        }
         return number_format(0, 2, ',', '.');
    }
}
if (!function_exists('__meta')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function __meta($section, $key)
    {
        $meta = Cache::remember('seo', env('CACHE_DURATION', 0), function () {
            return AporteWeb\Dashboard\Models\Seo::get();
        });
        if ($meta) {
            $meta = $meta->where('section', $section)->first();
            if ($meta && $meta->{$key} != '') {
                return $meta->{$key};
            }
        }
        return '';
    }
}

if (!function_exists('__config_var')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function __config_var($key, $model = false)
    {
        if ($model == false) {
            $var = Cache::remember('config_var', env('CACHE_DURATION', 0), function () {
                return AporteWeb\Dashboard\Models\ConfigVar::get()->pluck('config_value', 'config_key');
            })->toArray();
    
            if (is_array($var) && array_key_exists($key, $var)) {
                return $var[$key];
            }
        } else {
            $var = Cache::remember($model, env('CACHE_DURATION', 0), function () use ($model) {
                return $model::first();
            });
            return $var->{$key};
        }

        return null;
    }
}

if (!function_exists('__crudFolder')) {
    function __crudFolder()
    {
        $dirPath = app_path('Dashboard');
        if (file_exists($dirPath)) {
            if (!is_dir($dirPath)) {
                unlink($dirPath);
                mkdir($dirPath, 0777);
            }
        } else {
            mkdir($dirPath, 0777);
        }
        return $dirPath;
    }
}

if (!function_exists('__uuid')) {
    function __uuid()
    {
        return (string) \Illuminate\Support\Str::uuid();
    }
}

if (!function_exists('__slug')) {
    function __slug($string)
    {
        return \Illuminate\Support\Str::slug($string);
    }
}

if (!function_exists('__dolar')) {
    function __dolar()
    {
        /*
        // Esto estaba en la vista producto
        $data_in = "http://ws.geeklab.com.ar/dolar/get-dolar-json.php";
        $data_json = file_get_contents($data_in);
        if(strlen($data_json)>0) {
          $data_out = json_decode($data_json,true);
        }
        $usd=$data_out['libre'];
        */
        $client = new \Goutte\Client(\Symfony\Component\HttpClient\HttpClient::create(['timeout' => 60]));;
        if (@fsockopen('www.bna.com.ar', 80)) {
            // Seteo para que no se caiga por tiempo
            /*
            $guzzleClient = new \GuzzleHttp\Client(array(
                'timeout' => 90,
                'verify' => false,
            ));
            $client->setClient($guzzleClient);
            */

            $dolarPrice = Cache::remember('dolar', env('CACHE_DURATION', 0), function () use ($client) {
                $crawler = $client->request('GET', 'http://www.bna.com.ar/Personas');
                $table   = 'table cotizacion';

                $dolar   = $crawler->filter("[class='$table']")->filter('tr')->filter('td')->siblings();
                $dolar   = $dolar->nextAll();
                return $dolar->text();
            });

            return $dolarPrice;
        } else {
            return 63;
        }

    }
}

use Illuminate\Support\Facades\Schema;
if (!function_exists('__primary_key_usage')) {
    function __primary_key_usage($model, $value, $returnItem = false, $with = false, $withTrashed = false) {
        $check1 = Schema::hasColumn($model->getTable(), 'uuid');
        $check2 = is_string($value);
        $check3 = is_numeric($value);
        // regex para validar que sea un uuid, example: 4d29eec0-0807-11eb-b416-fd25c6e4ad5d, eb0d1204-2384-4f9c-a243-10a8399717dc
        // nota por primera vez me dio error validando un uuid, por eso lo valido con una expresion regular
        // $check3 = preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/', $value) === 1;
        // $check4 = preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $value) === 1;
        // $check5 = preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $value) === 1;
        //dd($check1, $check2, $check3);
        if ( 
            $check1
            && $check2
            && !$check3
            ) {
            $keyName = 'uuid';
        } else {
            $keyName = 'id';
        }
        if ($returnItem) {
            if ($with) {
                $model = $model->with($with);
            }
            if ($withTrashed) {
                $model = $model->withTrashed();
            }
            return $model->where($keyName, $value)->first();
        }
        return $keyName;
    }
}

use Illuminate\Support\Str;
if (!function_exists('__dashboardTask')) {
    function __dashboardTask(Closure $next) {
        // Doc
        // * * * * * cd /path-to-your-project && php artisan queue:work >> /dev/null 2>&1
        // php artisan queue:work
        // $migtrate = MigrateData::dispatch();

        $uuid = (string) Str::uuid();
        Storage::disk('local')->put('dashboard-task/' . $uuid . '.json', json_encode(['status' => 'waiting'], JSON_PRETTY_PRINT));
        dispatch(function () use ($uuid, $next) {
            Storage::disk('local')->put('dashboard-task/' . $uuid . '.json', json_encode(['status' => 'running'], JSON_PRETTY_PRINT));
            try {
                $callback = $next();
                Storage::disk('local')->put('dashboard-task/' . $uuid . '.json', json_encode(['status' => 'finish'] + $callback, JSON_PRETTY_PRINT));
            } catch (\Throwable $th) {
                Storage::disk('local')->put('dashboard-task/' . $uuid . '.json', json_encode([
                    'status' => 'failed',
                    'message' => $th->getMessage(),
                    'trace' => $th->getTraceAsString(),
                ], JSON_PRETTY_PRINT));
            }
        });
        return $uuid;
    }
}


use AporteWeb\Dashboard\Models\Gallery;
use AporteWeb\Dashboard\Models\Multimedia;
if (!function_exists('__storeGallery')) {
    function __storeGallery($id = false, array $data = [], String $ref = '') {
        $ids  = [];
        // 
        // Gallery
        if ($id) {
            $gallery = Gallery::where('id', $id)->firstOrNew();
        } else {
            $gallery = new Gallery;
        }
        $gallery->description = $ref;
        $gallery->save();
        if ($data && is_array($data)) {
            foreach ($data as $key => $value) {
                if(is_string($value)) {
                    $ids[$value] = [ 'order' => $key ];
                } else {
                    $path = $value->store('public/content/' . $this->tablename . '/');
                    $multimedia = new Multimedia;
                    $multimedia->path          = $path;
                    $multimedia->order         = null;
                    $multimedia->filename      = null;
                    $multimedia->alt           = null;
                    $multimedia->caption       = null;
                    $multimedia->original_name = null;
                    $multimedia->disk          = null;
                    $multimedia->meta_value    = null;
                    $multimedia->save();
                    $ids[$multimedia->id] = [ 'order' => $key ];
                }
            }
            $gallery->items()->sync($ids);
        } else {
            $gallery->items()->sync([]);
        }
        return $gallery->id;
    }
}
if (!function_exists('__getGallery')) {
    function __getGallery($id = false) {
        $items = [
            'value' => []
        ];
        if ($id) {
            $gallery = Gallery::find($id);
            if ($gallery) {
                foreach ($gallery->items as $key => $item) {
                    $items['value'][] = [
                        'url'  => asset(Storage::url($item->path)),
                        'path' => $item->path,
                        'id'   => $item->id,
                        'type' => Storage::mimeType($item->path)
                    ];
                }
            }
        }
        return $items;
    }
}
if (!function_exists('__getFirstGallery')) {
    function __getFirstGallery($id = false, $default = null) {
        if ($id) {
            $gallery = Gallery::find($id);
            if ($gallery && $gallery->items()->count()) {
                return $gallery->items()->first()->path;
            }
        }
        return $default;
    }
}
if (!function_exists('__toSql')) {
    function __toSql($query) {
        return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
            $binding = addslashes($binding);
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }
}

use Illuminate\Support\Facades\Mail;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use \AporteWeb\Dashboard\Models\EmailLayout;
use AporteWeb\Dashboard\Mail\Base AS BaseMail;

if (! function_exists('__send_mail')) {
    /**
     * Generate Title for table filter.
     *
     * @param  object  $item
     * @param  string  $metaKey
     * @return string
     */
    function __send_mail($layout_key, $mail, $to, $data, $components, $lang = 'default')
    {
    	if ($lang == 'default') {
        	$lang = LaravelLocalization::getCurrentLocale();
    	}
        $layout = EmailLayout::where('key', $layout_key . '_' . $lang)->first();

    	$mails = [
    		'base' => new BaseMail($layout, $data, $components),
    	];
    	
        Mail::to($to)->send($mails[$mail]);
    }
}

use Jenssegers\Date\Date;
if (! function_exists('__tableContentEval')) {
    /**
     * Generate Title for table filter.
     *
     * @param  string  $content
     * @return string
     */
    function __tableContentEval($content) {
        // search string __table_name__column_name__ and replace with column value
        // Example: __company_data__ultima_actualizacion_cte__
        $pattern = '/__(.*?)__(.*?)__/';
        $replace = function ($match) {
            $table = $match[1];
            $column = $match[2];
            $value = '';
            if (Schema::hasTable($table)) {
                if (Schema::hasColumn($table, $column)) {
                    // Check column type
                    $value = DB::table($table)->first()->$column;
                    $type = Schema::getColumnType($table, $column);
                    if ($type == 'datetime') {
                        // Format: miércoles, 03 de noviembre del 2021 a las 12:00 pm
                        $value = (new Date($value))->format('l, d \d\e F \d\e\l Y \a \l\a\s h:i a');
                    }
                }
            }
            return $value;
        };
        return preg_replace_callback($pattern, $replace, $content);
    }
}

if (! function_exists('__crudInfo')) {
    /**
     * Generate Title for table filter.
     *
     * @param  string  $tablename
     * @param  string  $columnname
     * @return array
     */
    function __crudInfo($tablename, $columnname = null) {
        $info = [];
        $dirPath  = app_path('Dashboard');
        $filePath = $dirPath . '/' . $tablename . '.json';

        if (file_exists($filePath)) {
            $content            = json_decode(file_get_contents($filePath));
            $info['tablename']  = $tablename;
            $info['table']      = $content->table;
            $info['inputs']     = $content->inputs;
            $info['conditions'] = $content->conditions;
        } else {
            return 'no-crud';
        }

        $className = str_replace(['_', '-', '.'], ' ', $tablename);
        $className = ucwords($className);
        $className = str_replace(' ', '', $className);
        $info['model'] = "\\App\\Models\\" . $className;
        try {
            if ( property_exists($content->table, 'model') && $content->table->model ) {
                $info['model'] = $content->table->model;
            }
        } catch (\Throwable $th) {
            dd($tablename);
        }
        if ($columnname) {
            foreach ($info['inputs'] as $key => $input) {
                if ($input->columnname == $columnname) {
                    $info['column'] = $input;
                    break;
                }
            }
        }
        return $info;
    }
}

if (!function_exists('__dCache')) {
    function __dCache($key, Closure $next) {
        $seconds = 60 * 60 * 24;
        $key = $key . '-'. app()->getLocale();
        if( auth()->guard('client')->check() ) {
            $key = $key . '-' . request()->session()->getId();
        }
        return Cache::remember($key, $seconds, function() use ($next) {
            return $next();
        });
    }
}

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

if (!function_exists('__paginate')) {
    function __paginate($items, $perPage = 15, $page = null, $baseUrl = null, $options = []) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? 
                       $items : Collection::make($items);

        $lap = new LengthAwarePaginator($items->forPage($page, $perPage), 
                           $items->count(),
                           $perPage, $page, $options);

        if ($baseUrl) {
            $lap->setPath($baseUrl);
        }

        return $lap;
    }
}

if (!function_exists('__pdfpath')) {
    function __pdfpath($path) {
        try {
            //code...
            return 'data:image/png;base64,' . base64_encode(file_get_contents(realpath(base_path('../public_html/' . $path))));
        } catch (\Throwable $th) {
            return '';
        }
    }
}