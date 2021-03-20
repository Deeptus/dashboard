<?php

namespace AporteWeb\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\Content;

class ContentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home($section)
    {
        $item = Content::firstOrCreate(['section' => $section]);
        //$element_meta = $item->meta()->pluck('meta_value', 'meta_key')->toArray();
        $config = config('dynamic-content.' . $section);
        return view('Dashboard::admin.content.home', [
            'section' => $section,
            'id' => $item->id,
            'element' => $item,
            'config'  => $config,
            //'element_meta'   => $element_meta,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Content::firstOrNew(['section' => $request->section]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/content');
            $item->image     = $path;
        }
        $item->title     = $request->title;
        $item->subtitle  = $request->subtitle;
        $item->text      = $request->text;
        $item->url       = $request->url;
        $item->save();
        $item->updateMeta($request);

        return redirect()->route('content', ['seccion' => $item->section])->with('status', 'Se actualizó el <strong>Contenido</strong> con éxito.');
    }
}
