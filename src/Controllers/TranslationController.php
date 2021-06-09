<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TranslationCreateRequest;
use App\Http\Requests\TranslationEditRequest;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\User;
use AporteWeb\Dashboard\Models\Translation;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Translation::get();
        return view('Dashboard::admin.translations.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Dashboard::admin.translations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Translation $item)
    {
        $item->key         = $request->key;
        $item->translation = $request->translation;
        $item->save();
        return redirect()->route('admin.translation')->with('success', 'Se añadio una <strong>Traducción</strong> con éxito.');
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
        return view('Dashboard::admin.translations.edit', [
            'element' => Translation::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Translation::find($id);
        $item->key         = $request->key;
        $item->translation = $request->translation;
        $item->save();
        return redirect()->route('admin.translation')->with('success', 'Se ha editado una <strong>Traducción</strong> con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Translation::find($id)->delete();
        return redirect()->route('admin.translation')->with('success', 'Se ha eliminado una <strong>Traducción</strong> con éxito.');
    }
    public function trash()
    {
        $data = Translation::onlyTrashed()->get();
        return view('Dashboard::admin.translations.index', [
            'data' => $data,
            'trash'=> true,
        ]);
    }
    public function restore($id)
    {
        $item = Translation::withTrashed()->find($id);
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.translation.trash')->with('success', 'Se ha restaurado un <strong>Traducción</strong> con éxito.');
    }
}
