<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\Content;
use AporteWeb\Dashboard\Models\ContentMeta;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Gallery;
use AporteWeb\Dashboard\Models\Multimedia;

class FileManagerController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function data() {
        $files = Multimedia::orderBy('id', 'desc')->get()->each->setAppends([
            'url',
            'type',
            'size',
            'width',
            'height'
        ]);
        return response()->json($files);
    }
    public function upload(Request $request) {
        $files = [];
        try {
            foreach ($request->items as $key => $item) {
                if($item->isValid()) {
                    $path = $item->store('public/content/multimedia/');
                    $multimedia = new Multimedia;
                    $multimedia->path          = $path;
                    $multimedia->order         = null;
                    $multimedia->filename      = basename($path);
                    $multimedia->alt           = null;
                    $multimedia->caption       = null;
                    $multimedia->original_name = $item->getClientOriginalName();
                    $multimedia->disk          = 'public';
                    $multimedia->meta_value    = null;
                    $multimedia->save();
                    $files[] = $multimedia->setAppends([
                        'url',
                        'type',
                        'size',
                        'width',
                        'height'
                    ]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json($files);
    }
}
