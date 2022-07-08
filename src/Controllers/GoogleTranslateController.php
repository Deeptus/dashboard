<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class GoogleTranslateController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function getTranslate() {
        $text = request()->text;
        $text = str_replace("\n", "",  $text);
        $text = str_replace("  ", " ", $text);
        $langs = LaravelLocalization::getLocalesOrder();
        $translated = [
            'es' => $text,
        ];
        $path_cache = 'google_translate/cache.json';
        if(Storage::exists($path_cache)) {
            $cache = json_decode(Storage::get($path_cache), true);
        } else {
            $cache = [];
        }

        foreach ($langs as $key => $lang) {
            if ($key == 'es') {
                continue;
            }
            $url = 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=es&tl='.$key.'&dt=t&q='.urlencode($text);
            if (!isset($cache[$url])) {
                $response = file_get_contents($url);
                $response = json_decode($response, true);
                $translated[$key] = '';
                foreach ($response[0] as $key2 => $value) {
                    $translated[$key] .= $value[0];
                }
                $translated[$key] = str_replace("http: //", "http://",  $translated[$key]);
                $cache[$url] = $translated[$key];
                Storage::put($path_cache, json_encode($cache, JSON_PRETTY_PRINT));
            } else {
                $translated[$key] = $cache[$url];
            }
        }
        return response()->json($translated);
        // foreach (LaravelLocalization::getLocalesOrder() as $key => $value) {
        //     $languages[$key] = $value['name'];
        // }
    }
}
