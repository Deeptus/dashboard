<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use AporteWeb\Dashboard\Requests\GroupCreateRequest;
use AporteWeb\Dashboard\Requests\GroupEditRequest;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\User;
use Junges\ACL\Http\Models\Group;
use Junges\ACL\Http\Models\Permission;
use Illuminate\Support\Str;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Group::get();
        return view('Dashboard::admin.grupos.index', [
            'data'           => $data,
            '__admin_active' => 'admin.grupo'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Dashboard::admin.grupos.create', [
            '__admin_active' => 'admin.grupo'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupCreateRequest $request, Group $item)
    {
        $item->name        = $request->name;
        $item->slug        = Str::slug($request->name);
        $item->description = $request->description;
        $item->save();
        return redirect()->route('admin.grupo')->with('success', 'Se añadio un <strong>Groupo</strong> con exitó.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('Dashboard::admin.grupos.edit', [
            'element'        => Group::find($id),
            '__admin_active' => 'admin.grupo'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupEditRequest $request, $id)
    {
        $item = Group::find($id);
        $item->name        = $request->name;
        $item->slug        = Str::slug($request->name);
        $item->description = $request->description;
        $item->save();
        return redirect()->route('admin.grupo')->with('success', 'Se ha editado un <strong>Groupo</strong> con exitó.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Group::find($id)->delete();
        return redirect()->route('admin.grupo')->with('success', 'Se ha eliminado un <strong>Groupo</strong> con exitó.');
    }
    public function trash()
    {
        $data = Group::onlyTrashed()->get();
        return view('Dashboard::admin.grupos.index', [
            'data'           => $data,
            'trash'          => true,
            '__admin_active' => 'admin.grupo'
        ]);
    }
    public function restore($id)
    {
        $item = Group::withTrashed()->find($id);
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.grupo.trash')->with('success', 'Se ha restaurado un <strong>Groupo</strong> con exitó.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function permission($id)
    {
        return view('Dashboard::admin.grupos.permission', [
            'element'        => Group::with('permissions')->find($id),
            'permissions'    => Permission::get(),
            '__admin_active' => 'admin.grupo'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePermission(Request $request, $id)
    {
        $item = Group::find($id);
        $item->permissions()->sync($request->permissions);
        return redirect()->route('admin.grupo')->with('success', 'Se ha editado un <strong>Groupo</strong> con exitó.');
    }

}
