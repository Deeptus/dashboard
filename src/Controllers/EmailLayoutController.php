<?php
namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use AporteWeb\Dashboard\Models\EmailLayout;

class EmailLayoutController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = EmailLayout::paginate(30);
        return view('Dashboard::admin.email-layout.index', [
            'data'     => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Dashboard::admin.email-layout.create', [
            'category_id' => request()->category_id
        ]);
    }


    public function data($id = false)
    {
        $sizes  = [];
        $colors = [];

        $languages = [];
        $images = [];
        $content = [];
        $objects = [];
        if($id) {
            $content = [];
            foreach (EmailLayout::find($id)->getAttributes() as $var_key => $var_value) {
                if (in_array($var_key, $images)) {
                    if($var_value != null && $var_value != '' && Storage::exists($var_value)) {
                        $content[$var_key] = [
                            'url'  => asset(Storage::url($var_value)),
                            'path' => $var_value,
                            'type' => Storage::mimeType($var_value)
                        ];
                    }
                } else if (in_array($var_key, $objects)) {
                    $content[$var_key] = json_decode($var_value ?? '{}');
                } else {
                    $content[$var_key] = $var_value;
                }
            }
        }
        foreach (LaravelLocalization::getLocalesOrder() as $key => $value) {
            $languages[$key] = $value['name'];
        }
        return response()->json([
            'languages'           => $languages,
            'config'              => [],
            'content'             => $content,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, $id = false)
    {
        if($id){
            $item = EmailLayout::find($id);
        } else {
            $item  = new EmailLayout;
        }
        $item->key         = $request->key;
        $item->description = $request->description;
        $item->subject     = $request->subject;
        $item->body        = $request->body;
        $item->save();
        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('Dashboard::admin.email-layout.edit', [
            'element' => EmailLayout::find($id),
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EmailLayout::find($id)->delete();
        return redirect()->route('admin.email-layout')->with('success', 'Se ha eliminado un <strong>product</strong> con exitó.');
    }
    public function trash()
    {
        $data = EmailLayout::onlyTrashed()->paginate(30);
        return view('Dashboard::admin.email-layout.index', [
            'data' => $data,
            'trash'=> true,
        ]);
    }
    public function restore($id)
    {
        $item = EmailLayout::withTrashed()->find($id);
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.email-layout.trash')->with('success', 'Se ha restaurado un <strong>product</strong> con exitó.');
    }
    public function copy($id)
    {
        $new = EmailLayout::find($id)->replicate();
        $new->save();
        return redirect()->route('admin.email-layout.edit', $new->id)->with('success', 'Se ha duplicado un <strong>product</strong> con exitó.');
    }
}
