<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\Content;
use AporteWeb\Dashboard\Models\ContentMeta;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DynamicContentController extends Controller
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

    public function data($section, $id = false)
    {
        $languages = [];
        $content = null;
        foreach (LaravelLocalization::getLocalesOrder() as $key => $value) {
            $languages[$key] = $value['name'];
        }
        if ($id) {
            $content = [];
            foreach (Content::find($id)->getAttributes() as $key => $value) {
                if ($key == 'image') {
                    if($value != null){
                        foreach (json_decode($value) as $lang => $image) {
                            $content[$key][$lang] = asset(Storage::url($image));
                        }
                    } else {
                        $content[$key] = json_decode('{}');
                    }
                } elseif ($key == 'gallery') {
                    if($value != null){
                        foreach (json_decode($value) as $lang => $image) {
                            $content[$key][] = [
                                'url' => asset(Storage::url($image)),
                                'path' => $image,
                            ];
                        }
                    } else {
                        $content[$key] = [];
                    }
                } elseif($key == 'date' || $key == 'featured') {
                    $content[$key] = $value;
                } elseif($key == 'sitio_web') {
                    $content[$key] = $value;
                } else {
                    if ($value != null){
                        $content[$key] = json_decode($value);
                    } else {
                        if($key == 'lang') {
                            $content[$key] = [];
                        } else {
                            $content[$key] = json_decode('{}');
                        }
                    }
                }
            }
        }
        return response()->json([
            'languages' => $languages,
            'config' => config('dynamic-content.' . $section),
            'content' => $content,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($section)
    {
        $data = Content::where('section', $section)->orderBy('order', 'ASC')->paginate(20);
        $config = config('dynamic-content.' . $section);
        //dd($config);
        $inputs = ['order', 'title', 'subtitle', 'text', 'description'];
        return view('Dashboard::admin.dynamic-content.index', [
            'data' => $data,
            'section' => $section,
            'config' => $config,
            'inputs' => $inputs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($section)
    {
        $config = config('dynamic-content.' . $section);
        return view('Dashboard::admin.dynamic-content.create', [
            'section' => $section,
            'config'  => $config,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($section, Request $request, Content $item)
    {
        $image = [];
        $data = json_decode($request->data);
        if($request->images != null){
            foreach ($request->images as $key => $value) {
                $path = $value->store('public/content/images/');
                $image[$key] = $path;
            }
        }
        if($request->gallery != null){
            foreach ($request->gallery as $key => $value) {
                $path = $value->store('public/content/gallery/');
                $gallery[$key] = $path;
            }
            $item->gallery  = $gallery;
        }

        if($data->sitio_web){
            $item->sitio_web  = $data->sitio_web;
        }
        $item->lang        = (array) $data->lang;
        $item->setTranslations('order', (array) $data->order);
        $item->setTranslations('title', (array) $data->title);
        $item->setTranslations('subtitle', (array) $data->subtitle);
        $item->setTranslations('text', (array) $data->text);
        $item->setTranslations('description', (array) $data->description);
        $item->setTranslations('image', (array) $image);
        $item->date     = $data->date!=''?$data->date:null;
        $item->featured = $data->featured;
        if (property_exists($data, 'tags')) {
            $item->tags     = $data->tags;
        }
        $item->section  = $section;
        $item->save();

        //$item->updateMeta($request);

        return response()->json(['message' => 'guardado']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Content::find($id);
        //$element_meta = $item->meta()->pluck('meta_value', 'meta_key')->toArray();
        $config = config('dynamic-content.' . $item->section);
        return view('Dashboard::admin.dynamic-content.edit', [
            'section' => $item->section,
            'id' => $id,
            'element' => $item,
            'config'  => $config,
            //'element_meta'   => $element_meta,
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
        $item = Content::find($id);
        $image = [];
        $data = json_decode($request->data);
        if($request->images != null){
            foreach ($request->images as $key => $value) {
                if(!is_string($value)) {
                    $path = $value->store('public/content/images/');
                    $image[$key] = $path;
                }
            }
        }
        if($request->gallery != null){
            foreach ($request->gallery as $key => $value) {
                if(is_string($value)) {
                    $gallery[$key] = $value;
                } else {
                    $path = $value->store('public/content/gallery/');
                    $gallery[$key] = $path;
                }
            }
            $item->gallery  = $gallery;
        }
        if( property_exists($data, 'sitio_web') && $data->sitio_web){
            $item->sitio_web  = $data->sitio_web;
        }
        $item->setTranslations('image', (array) $image);
        $item->lang        = (array) $data->lang;
        $item->setTranslations('order', (array) $data->order);
        $item->setTranslations('title', (array) $data->title);
        $item->setTranslations('subtitle', (array) $data->subtitle);
        $item->setTranslations('text', (array) $data->text);
        $item->setTranslations('description', (array) $data->description);
        $item->date     = $data->date;
        $item->featured = $data->featured;
        // $item->tags     = @$data->tags;
        $item->save();

        //$item->updateMeta($request);

        return response()->json(['message' => 'editado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Content::find($id);
        $section = $item->section;
        $item->delete();
        return redirect()->route('admin.dynamic-content', [$section])->with('status', 'Se elimino un <strong>item</strong> del slider con éxito.');
    }
    public function trash($section)
    {
        $data   = Content::onlyTrashed()->get();
        $config = config('dynamic-content.' . $section);
        $inputs = ['order', 'title', 'subtitle', 'text', 'description'];
        
        return view('Dashboard::admin.dynamic-content.index', [
            'data' => $data,
            'section' => $section,
            'config' => $config,
            'trash'=> true,
            'inputs' => $inputs,
        ]);
    }
    public function restore($id)
    {
        $item = Content::withTrashed()->find($id);
        $section = $item->section;
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.dynamic-content.trash', [$section])->with('success', 'Se ha restaurado un <strong>item</strong> con éxito.');
    }
    public function copy($id)
    {
        $new = Content::find($id)->replicate();
        $section = $new->section;
        $new->save();
        return redirect()->route('admin.dynamic-content.edit', $new->id)->with('success', 'Se ha duplicado un <strong>item</strong> con éxito.');
    }
}
