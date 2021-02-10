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
    function __t($key)
    {
        $item = \AporteWeb\Dashboard\Models\Translation::where('key', $key)->first();
        if ($item) {
            return $item->translation;
        } else {
            return $key;
        }
    }
}
if (!function_exists('__active')) {
    function __active($var, $active)
    {
        if ($var == $active) {
            return 'active';
        }
        return '';
    }
}

if (!function_exists('__collapsed')) {
    function __collapsed($var, $active)
    {
        if ($var == $active) {
            return 'true';
        }
        return 'false';
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
        return null;
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
    function __config_var($key)
    {
        $var = Cache::remember('config_var', env('CACHE_DURATION', 0), function () {
            return AporteWeb\Dashboard\Models\ConfigVar::get()->pluck('config_value', 'config_key');
        })->toArray();

        if (is_array($var) && array_key_exists($key, $var)) {
            return $var[$key];
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