<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\User;
use App\Models\Sucursal;
use Junges\ACL\Models\Group;
use Junges\ACL\Models\Permission;
use Illuminate\Support\Str;

class ToolsController extends Controller {

    public function index() {
        return view('Dashboard::admin.tools.index', [
            '__admin_active' => 'admin.tools'
        ]);
    }
    public function cacheClear() {
        $message = 'Cache cleared successfully<br>';
        \Artisan::call('cache:clear');
        $message .= 'cache:clear<br>';
        return redirect()->back()->with('success', $message);
    }
    public function cacheClearAll() {
        $message = 'All cache cleared successfully<br>';
        \Artisan::call('cache:clear');
        $message .= 'cache:clear<br>';
        \Artisan::call('view:clear');
        $message .= 'view:clear<br>';
        \Artisan::call('route:clear');
        $message .= 'route:clear<br>';
        \Artisan::call('config:clear');
        $message .= 'config:clear<br>';
        return redirect()->back()->with('success', $message);
    }
    public function updateAssetsVersion() {
        $message = 'Assets version updated successfully<br>';
        $assets_version = env('ASSETS_VERSION');
        $assets_version = $assets_version + 1;
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace('ASSETS_VERSION='.env('ASSETS_VERSION'), 'ASSETS_VERSION='.$assets_version, file_get_contents($path)));
        }
        $message .= 'New assets version: ' . $assets_version . '<br>';
        return redirect()->back()->with('success', $message);
    }
}
