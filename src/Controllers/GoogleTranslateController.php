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
        $text = json_decode(request()->text, true)['es'];
        $text = str_replace("\n", "", $text);
        $text = str_replace("  ", " ", $text);
        $langs = LaravelLocalization::getLocalesOrder();
        $translated = [
            'es' => $text,
        ];
        foreach ($langs as $key => $lang) {
            if ($key == 'es') {
                continue;
            }
            $url = 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=es&tl='.$key.'&dt=t&q='.urlencode($text);
            $response = file_get_contents($url);
            $response = json_decode($response, true);
            $translated[$key] = $response[0][0][0];
        }
        return response()->json($translated);
        // foreach (LaravelLocalization::getLocalesOrder() as $key => $value) {
        //     $languages[$key] = $value['name'];
        // }
    }
}
