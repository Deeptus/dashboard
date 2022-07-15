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

class MultimediaController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        /*
        $appends = [];
        $trash   = false;
        $data = new Multimedia;
        if (request()->has('enable-trash')) {
            $trash = true;
            $data  = $data->onlyTrashed();
        }
        if (request()->has('s')) {
            $appends['s'] = request()->s;
            $cols = \DB::getSchemaBuilder()->getColumnListing((new Multimedia)->getTable());
            $data = $data->where(function ($query) use ($cols) {
                foreach ($cols as $col) {
                    $query->orWhere($col, 'like', '%'.request()->s.'%');
                }
            });
        }
        if (request()->has('paginate')) {
            $data = $data->paginate(request()->paginate);
            $appends['paginate'] = request()->paginate;
        } else {
            $data = $data->paginate(20);
        }
        $data->appends($appends);
        */
        return view('Dashboard::admin.multimedia.index', [
            // 'data' => $data,
            // 'trash'          => $trash,
            '__admin_active' => 'admin.multimedia'
        ]);
    }
    /*
    public function destroy($id) {
        $item = Multimedia::find($id);
        $item->delete();
        return redirect()->route('admin.multimedia', ['id' => $item->id])->with('status', 'Se elimino un <strong>item</strong> con éxito.');
    }

    public function restore($id) {
        $item = Multimedia::withTrashed()->find($id);
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.multimedia', ['enable-trash'])->with('success', 'Se ha restaurado un <strong>item</strong> con éxito.');
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
                    $multimedia->filename      = null;
                    $multimedia->alt           = null;
                    $multimedia->caption       = null;
                    $multimedia->original_name = null;
                    $multimedia->disk          = null;
                    $multimedia->meta_value    = null;
                    $multimedia->save();
                    $files[] = $multimedia->setAppends([
                        'url',
                        'type'
                    ]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json($files);
    }
    */
    public function download($id, $original_name) {
        $multimedia = Multimedia::where('id', $id)->where('original_name', $original_name)->first();
        if ($multimedia) {
            $path = $multimedia->path;
            $file = Storage::get($path);
            return response()->make($file, 200, [
                'Content-Type' => Storage::mimeType($path),
                'Content-Length' => Storage::size($path),
                'Content-Disposition' => 'attachment; filename="'.$multimedia->original_name.'"'
            ]);
        } else {
            return response()->json([
                'error' => 'No se encontro el archivo'
            ], 404);
        }
    }
    public function stream($id, $original_name) {
        $multimedia = Multimedia::where('id', $id)->where('original_name', $original_name)->first();
        // display the file y stream it to the browser
        if ($multimedia) {
            $path = $multimedia->path;
            $file = Storage::get($path);
            return response()->make($file, 200, [
                'Content-Type' => Storage::mimeType($path),
                'Content-Length' => Storage::size($path),
                'Content-Disposition' => 'inline; filename="'.$multimedia->original_name.'"'
            ]);
            /*
            header("Content-Length: " . Storage::size($path));
            header('Content-Type: ' . Storage::mimeType($path));
            header('Content-Disposition: inline; filename="' . $multimedia->original_name.'"');
            header('Content-Length: '.Storage::size($path));
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            readfile(Storage::path($path));
            /*
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream'); // Storage::mimeType($path)
            header('Content-Disposition: attachment; filename="'.$multimedia->original_name.'"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . Storage::size($path));
            ob_clean();
            flush();
            readfile($path);
            exit;
            */
            // dd($path, Storage::url($path), Storage::path($path));
        } else {
            return response()->json([
                'error' => 'No se encontro el archivo'
            ], 404);
        }
    }
}
