<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\User;
use App\Models\Sucursal;
use Junges\ACL\Http\Models\Group;
use Junges\ACL\Http\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::get();
        return view('Dashboard::admin.users.index', [
            'data' => $data,
            '__admin_active' => 'admin.user'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $groups  = Group::get();
        if (class_exists('App\Models\Sucursal')) {
            $sucursales = Sucursal::with('tienda')->get();
        } else {
            $sucursales = [];
        }
        return view('Dashboard::admin.users.create', [
            'groups' => $groups,
            'sucursales' => $sucursales,
            '__admin_active' => 'admin.user'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $uuid = null)
    {
        request()->validate([
            'email'    => ['required', 'unique:users'],
            'username' => ['required', 'unique:users'],
        ]);

        if($uuid){
            $item   = User::where('uuid', $uuid)->firstOrFail();
            $action = 'edito';
            if ($request->root != null && $request->root != '' && auth()->user()->root) {
                $item->root = $request->root;
            }
        } else {
            $item       = new User;
            $action     = 'añadio';
            $item->root = 0;
            if (Schema::hasColumn($item->getTable(), 'uuid')) {
                $item->uuid = __uuid();
            }
        }
        $item->name       = $request->name;
        $item->username   = $request->username;
        $item->email      = $request->email;
        $item->password   = bcrypt($request->password);
        $item->root       = $request->root;
        //$item->sucursal_id  = $request->sucursal_id;
        $item->save();
        $item->groups()->sync($request->groups);
        return redirect()->route('admin.user')->with('success', 'Se añadio un <strong>Usuario</strong> con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($keyValue) {

        // Verifico si es root
        if (auth()->user()->root) {
            // consulto Grupos
            $groups  = Group::get();
        } else {
            // consulto Grupos
            $groups  = Group::where('display_only_root', 0)->get();
        }
        
        $element = __primary_key_usage(new User, $keyValue, true, ['groups']);

        // dd($keyName, $keyValue);
        $user_groups = $element->groups()->pluck('id')->toArray();
        return view('Dashboard::admin.users.edit', [
            'groups' => $groups,
            'element' => $element,
            'user_groups' => $user_groups,
            '__admin_active' => 'admin.user'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $keyValue) {

        request()->validate([
            'email'    => ['required', Rule::unique('users')->ignore( $keyValue, __primary_key_usage( new User, $keyValue ) )],
            'username' => ['required', Rule::unique('users')->ignore( $keyValue, __primary_key_usage( new User, $keyValue ) )],
        ]);

        $item = __primary_key_usage(new User, $keyValue, true);

        if ($request->password != null && $request->password != '') {
            $item->password = bcrypt($request->password);
        }
    
        $item->name       = $request->name;
        $item->username   = $request->username;
        $item->email      = $request->email;
        $item->root       = $request->root;
        //$item->sucursal_id  = intval($request->sucursal_id);
        $item->save();
        $item->groups()->sync($request->groups);
        return redirect()->route('admin.user')->with('success', 'Se ha editado un <strong>Usuario</strong> con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($keyValue) {

        $item = __primary_key_usage(new User, $keyValue, true);
        $item->delete();

        return redirect()->route('admin.user')->with('success', 'Se ha eliminado un <strong>Usuario</strong> con éxito.');
    }
    public function trash()
    {
        $data = User::onlyTrashed()->get();
        return view('Dashboard::admin.users.index', [
            'data' => $data,
            'trash'=> true,
            '__admin_active' => 'admin.user'
        ]);
    }
    public function restore($keyValue) {

        $item = __primary_key_usage(new User, $keyValue, true, false, true);
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.user.trash')->with('success', 'Se ha restaurado un <strong>Usuario</strong> con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function permission($keyValue)
    {
        $item = __primary_key_usage(new User, $keyValue, true);

        return view('Dashboard::admin.users.permission', [
            'element' => $item,
            'permissions' => Permission::get(),
            '__admin_active' => 'admin.user'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePermission(Request $request, $keyValue)
    {
        $item = __primary_key_usage(new User, $keyValue, true);
        $item->permissions()->sync($request->permissions);
        return redirect()->route('admin.user')->with('success', 'Se ha editado un <strong>Usuario</strong> con éxito.');
    }

}
