<?php

namespace AporteWeb\Dashboard\Controllers;

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
    public function home($section) {
        $dominios = config('dominios');
        $server = request()->server();
        $sitio_web = null;
        if (array_key_exists('dominio', $dominios)) {
            $sitio_web = array_search($server['SERVER_NAME'], $dominios['dominio']);
            if (!$sitio_web) {
                $sitio_web = array_key_first($dominios['dominio']);
            }
            $item = Content::firstOrCreate(['section' => $section, 'sitio_web' => $sitio_web]);
        } else {
            $item = Content::firstOrCreate(['section' => $section]);
        }
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
        if($request->sitio_web){
            $item->sitio_web  = $data->sitio_web;
        }
        $item->save();
        $item->updateMeta($request);

        return redirect()->route('content', ['seccion' => $item->section])->with('status', 'Se actualizó el <strong>Contenido</strong> con éxito.');
    }
}
