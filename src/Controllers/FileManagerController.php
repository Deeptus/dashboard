<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\Content;
use AporteWeb\Dashboard\Models\ContentMeta;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Gallery;
use AporteWeb\Dashboard\Models\Multimedia;

use Tinify;

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
                    if ( $request->upload_mode == 'normal' ) {
                        $multimedia = new Multimedia;
                        $message = 'success-new';
                    }
                    if ( $request->upload_mode == 'replace-same-name' ) {
                        $multimedia = Multimedia::where('original_name', $item->getClientOriginalName())->first();
                        $message = 'success-replace';
                        if ( !$multimedia ) {
                            $multimedia = new Multimedia;
                            $message = 'success-new';
                        }
                    }
                    $multimedia->path          = $path;
                    $multimedia->order         = null;
                    // $multimedia->filename      = basename($path);
                    $multimedia->filename      = $item->getClientOriginalName();
                    $multimedia->alt           = null;
                    $multimedia->caption       = null;
                    $multimedia->original_name = $item->getClientOriginalName();
                    $multimedia->disk          = 'public';
                    $multimedia->meta_value    = null;
                    $multimedia->save();
                    $files[$key] = $multimedia->setAppends([
                        'url',
                        'type',
                        'size',
                        'width',
                        'height'
                    ]);
                    $files[$key]['message'] = $message;
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json($files);
    }
    public function optimize($id = false) {
        set_time_limit(0);
        if ($id) {
            $files = Multimedia::where('id', $id)->get();
        } else {
            $files = Multimedia::get();
        }
        foreach ($files as $key => $file) {

            if ( !Storage::exists($file->path) ) {
                continue;
            }

            $path          = Storage::path($file->path);
            $dirname       = pathinfo($path)['dirname'];
            $basename      = pathinfo($path)['basename'];
            $extension     = pathinfo($path)['extension'];
            $filename      = pathinfo($path)['filename'];
            $backup_folder = 'public/content/multimedia/backup/';
            if ( !Storage::exists($backup_folder) ) {
                Storage::makeDirectory($backup_folder);
            }
            $command = false;
            if ($extension == 'jpg' || $extension == 'jpeg') {
                $command = 'jpegoptim -m80 --strip-all ' . $path;
            }
            if ($extension == 'png') {
                $command = 'optipng -o7 ' . $path;
            }
            if ($extension == 'gif') {
                $command = 'gifsicle -O3 --lossy=80-100 ' . $path;
            }
            if ($command) {
                exec($command, $output, $return);
                $backup_path = $backup_folder . $filename . '.' . $extension;
                Storage::move($file->path, $backup_path);
                $file->setMeta('original_file', $backup_path);
            }
            if ($extension != 'webp') {
                // convert file to webp
                $webp = $dirname . '/' . $filename . '.webp';
                $command = 'cwebp -q 100 -m 6 ' . Storage::path($backup_path) . ' -o ' . $webp;
                exec($command, $output, $return);
                // use Tinify to optimize webp
                \Tinify\setKey("j2LD2pYV7B0xllLVBy4YCWrVDNH5cDdG");
                $source = \Tinify\fromFile($webp);
                $source->toFile($webp);
                $file->setMeta('optimized_webp', true);
                $file->path = 'public/content/multimedia/' . $filename . '.webp';
                $file->save();
            }
            return response()->json($file->setAppends([
                'url',
                'type',
                'size',
                'width',
                'height'
            ]));
        }
    }
    public function delete($id) {
        $file = Multimedia::find($id);
        if ( $file ) {
            $file->delete();
            return response()->json(['message' => 'success-delete']);
        }
        return response()->json(['message' => 'error-delete']);
    }
    public function rotate($id, $direction) {
        $file = Multimedia::find($id);
        if ( $file ) {
            if ( $direction == 'left' ) {
                $degrees = 90;
            }
            if ( $direction == 'right' ) {
                $degrees = -90;
            }
            $path = Storage::path($file->path);
            // rotate image, using imagerotate
            $extension = pathinfo($path)['extension'];
            if ( $extension == 'jpg' || $extension == 'jpeg' ) {
                $image = @imagecreatefromjpeg($path);
                $rotate = imagerotate($image, $degrees, 0);
                imagejpeg($rotate, $path);
            }
            if ( $extension == 'png' ) {
                $image = @imagecreatefrompng($path);
                $rotate = imagerotate($image, $degrees, 0);
                imagepng($rotate, $path);
            }
            if ( $extension == 'gif' ) {
                $image = @imagecreatefromgif($path);
                $rotate = imagerotate($image, $degrees, 0);
                imagegif($rotate, $path);
            }
            if ( $extension == 'webp' ) {
                $image = @imagecreatefromwebp($path);
                $rotate = imagerotate($image, $degrees, 0);
                imagewebp($rotate, $path);
            }
            // update basename on path
            $basename = pathinfo($path)['basename'];
            // get new basename
            $new_basename = Str::random(30) . '.' . $extension;
            // set new path
            $new_path = str_replace($basename, $new_basename, $file->path);
            Storage::move($file->path, $new_path);
            $file->path = $new_path;
            $file->save();
            $file->setAppends([
                'url',
                'type',
                'size',
                'width',
                'height'
            ]);
            return response()->json($file);
        }
        return response()->json(['message' => 'error-delete']);
    }
}
