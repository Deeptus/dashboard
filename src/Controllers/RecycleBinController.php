<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\Content;
use AporteWeb\Dashboard\Models\ContentMeta;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Gallery;
use AporteWeb\Dashboard\Models\Multimedia;
use AporteWeb\Dashboard\Models\RecycleBin;
use Illuminate\Support\Facades\Schema;

class RecycleBinController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        $data = RecycleBin::orderBy('id', 'desc')->paginate(10);
        return view('Dashboard::admin.recycle_bin.index', [
            'data'           => $data,
            '__admin_active' => 'admin.recycle-bin'
        ]);
    }

}
