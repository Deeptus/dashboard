<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Content;

// use App\Models\HomeBanner;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use App\Mail\SendMailContacto;
use App\Mail\SendMailPurchases;

use AporteWeb\Dashboard\Models\ConfigVar;
use Carbon\Carbon;
use Jenssegers\Date\Date;

use App\Libs\Oca;
use App\Libs\Cart;

class WebsiteController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return 'Hola mundo';
        // $banner     = HomeBanner::orderBy('order_index')->get();
        view()->share('active', 'website.home');
        view()->share('search', '');
        return view('web.home', [
            'search'     => '',
        ]);
    }
}
