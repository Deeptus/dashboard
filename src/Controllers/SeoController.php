<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SeoCreateRequest;
use App\Http\Requests\SeoEditRequest;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\User;
use AporteWeb\Dashboard\Models\Seo;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Seo::get();
        $sections = config('seo');
        return view('Dashboard::admin.seo.index', [
            'data' => $data,
            'sections' => $sections
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($section)
    {
        $section = Seo::firstOrCreate(['section' => $section]);
        return view('Dashboard::admin.seo.edit', [
            'section' => $section,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $section)
    {
        $item = Seo::firstOrCreate(['section' => $section]);
        $item->section         = $section;
        $item->setTranslations('title', (array) $request->title);
        $item->setTranslations('description', (array) $request->description);
        $item->setTranslations('keywords', (array) $request->keywords);
        $item->save();
        return redirect()->route('admin.seo')->with('success', 'Se ha editado la inforación meta de una <strong>Sección</strong> con éxito.');
    }
}
