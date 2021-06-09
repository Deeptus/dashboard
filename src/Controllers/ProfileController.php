<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\User;
use App\Models\Sucursal;
use Junges\ACL\Http\Models\Group;
use Junges\ACL\Http\Models\Permission;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $element = auth()->user();
        return view('Dashboard::admin.profile.index', [
            'element' => $element,
            '__admin_active' => 'admin.profile'
        ]);
    }

    public function update(Request $request)
    {
        $item = auth()->user();
        if ($request->password != null && $request->password != '') {
            $item->password = bcrypt($request->password);
        }
        $item->name       = $request->name;
        $item->username   = $request->username;
        $item->email      = $request->email;
        $item->save();
        return redirect()->route('admin.profile')->with('success', 'Se ha editado su <strong>perfil</strong> con éxito.');
    }

}
