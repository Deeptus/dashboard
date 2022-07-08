<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Marketplace\PriceList;

class MarketplaceController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function getPriceList() {
        $priceList = PriceList::get();
        $data = [];
        foreach ($priceList as $key => $value) {
            $data[$key]['name'] = $value->name;

        }
        return response()->json([
            'data' => $data
        ]);
    }
}
