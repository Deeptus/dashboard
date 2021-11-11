<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\Content;
use AporteWeb\Dashboard\Models\ContentMeta;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CompanyDataController extends Controller
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

    public function data()
    {
        $languages = [];
        foreach (LaravelLocalization::getLocalesOrder() as $key => $value) {
            $languages[$key] = $value['name'];
        }
        return response()->json([
            'languages' => $languages,
            'content' => [],
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Dashboard::admin.companydata.index', [
            '__admin_active' => 'admin.companydata',
        ]);
    }
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
        $item->setTranslations('image', (array) $image);
        $item->lang        = (array) $data->lang;
        $item->setTranslations('order', (array) $data->order);
        $item->setTranslations('title', (array) $data->title);
        $item->setTranslations('subtitle', (array) $data->subtitle);
        $item->setTranslations('text', (array) $data->text);
        $item->setTranslations('description', (array) $data->description);
        $item->date     = $data->date;
        $item->featured = $data->featured;
        $item->save();

        //$item->updateMeta($request);

        return response()->json(['message' => 'editado']);
    }
}
