<?php

namespace AporteWeb\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\Content;
use AporteWeb\Dashboard\Models\ContentMeta;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;



class CrudController extends Controller
{
    private $model;
    private $tablename;
    private $table;
    private $inputs;

    public function __construct()
    {
        $this->middleware('auth');

        $this->tablename = request()->route()->parameters()['tablename'];

        if($this->tablename) {
            $dirPath  = app_path('Dashboard');
            $filePath = $dirPath . '/' . $this->tablename . '.json';

            if (file_exists($filePath)) {
                $content      = json_decode(file_get_contents($filePath));
                $this->table  = $content->table;
                $this->inputs = $content->inputs;

            }
//            dd($temp);

            $className = str_replace(['_', '-', '.'], ' ', $this->tablename);
            $className = ucwords($className);
            $className = str_replace(' ', '', $className);
            $this->model = "\\App\\Models\\" . $className;
        }

    }


    public function data($tablename, $id = false)
    {

        $content = null;
        $relations = [];
        $languages = [];

        foreach (LaravelLocalization::getLocalesOrder() as $key => $value) {
            $flag = 'es';
            if($key == 'pt'){
                $flag = 'br';
            }
            if($key == 'en') {
                $flag = 'us';
            }
            $languages[] = [ 'key' => $value['name'], 'value' => $key, 'flag' => $flag];
        }

        if ($id) {
            $item = $this->model::where('id', $id)->firstOrFail();
            foreach ($this->inputs as $inputKey => $input) {
                $content[$input->columnname] = $item->{$input->columnname};
                $content[$input->columnname.'_en'] = $item->{$input->columnname.'_en'};
                $content[$input->columnname.'_pt'] = $item->{$input->columnname.'_pt'};
            }    
        }

        foreach ($this->inputs as $inputKey => $input) {
            
            if ($input->type == 'select' && $input->valueoriginselector == 'table') {
                $relations[$input->tabledata] = DB::table($input->tabledata)
                                ->whereNull('deleted_at')
                                ->pluck($input->tabletextcolumn, $input->tablekeycolumn);
            }

        }    

        return response()->json([
            'languages' => $languages,
            'locale'    => App::getLocale(),
            'tablename' => $this->tablename,
            'table'     => $this->table,
            'inputs'    => $this->inputs,
            'relations' => $relations,
            'content' => $content
        ]);
    }

    public function index()
    {
        $data = $this->model::get();
        $relations = [];
        $languages = [];

        foreach (LaravelLocalization::getLocalesOrder() as $key => $value) {

            $flag = 'es';
            if($key == 'pt'){
                $flag = 'br';
            }
            if($key == 'en') {
                $flag = 'us';
            }
            $languages[] = [ 'key' => $value['name'], 'value' => $key, 'flag' => $flag];
        }

        foreach ($this->inputs as $inputKey => $input) {
            
            if ($input->type == 'select' && $input->valueoriginselector == 'table') {
                $relations[$input->tabledata] = DB::table($input->tabledata)
                                ->whereNull('deleted_at')
                                ->pluck($input->tabletextcolumn, $input->tablekeycolumn);
            }

        }    

        return response()->json([
            'data'           => $data,
            'tablename'      => $this->tablename,
            'relations'      => $relations,
            'languages'      => $languages,
            'table'          => $this->table,
            'inputs'         => $this->inputs,
            '__admin_active' => 'admin.crud.' . $this->tablename
        ]);
    }

    public function create()
    {
        return view('Dashboard::admin.crud.create', [
            'tablename'      => $this->tablename,
            'table'          => $this->table,
            'inputs'         => $this->inputs,
            '__admin_active' => 'admin.crud.' . $this->tablename
        ]);
    }

    public function store(Request $request, $tablename, $id = false)
    {

        $validHelper = array();

        if($id){
            $item       = $this->model::where('id', $id)->firstOrFail();
            $action     = 'edito';
        } else {
            $item       = new $this->model;
            $action     = 'añadio';
        }

        foreach ($this->inputs as $inputKey => $input) {

           

            if($input->nullable == 0){
                //echo $input->columnname.' requerido';
                $validHelper[$input->columnname] = 'required';
            }


           
           
        }

        $validatedData = $request->validate($validHelper);

        //dd($validHelper);

        foreach ($this->inputs as $inputKey => $input) {

            //echo $input->columnname;

            if($input->type == 'file'){

                if($request->hasFile('file')){

                    $path = $request->file->store('public/content/' . $this->tablename . '/');
                    $item->{$input->columnname} = $path;

                }
            }else if($input->type == 'boolean'){
                if($request->{$input->columnname} == 'true'){
                    $item->{$input->columnname} = 1;
                }else{
                    $item->{$input->columnname} = 0;
                }
                
            }else{
                
                if($input->translatable){
                    $item->{$input->columnname.'_pt'} = $request->{$input->columnname.'_pt'};
                    $item->{$input->columnname.'_en'} = $request->{$input->columnname.'_en'};
                }

                if($request->{$input->columnname} !== 'null' && $request->{$input->columnname} !== 'undefined' ){
                    
                    $item->{$input->columnname} = $request->{$input->columnname};

                }

            }
        }
        
        $item->save();

        return response()->json(['message' => 'Se ' . $action . ' con éxito.']);
    }

    public function edit($tablename, $id)
    {
        $item = $this->model::find($id);
        return view('Dashboard::admin.crud.edit', [
            'item'           => $item,
            'tablename'      => $this->tablename,
            'table'          => $this->table,
            'inputs'         => $this->inputs,
            '__admin_active' => 'admin.crud.' . $this->tablename
        ]);
    }

    public function destroy($tablename, $id)
    {
        $item = $this->model::findOrFail($id);
        $item->delete();

                return response()->json(['message' => 'Se  elimino con éxito.']);
       /* return redirect()->route('admin.crud', ['tablename' => $tablename, 'id' => $item->id])->with('status', 'Se elimino un <strong>item</strong> con éxito.');*/
    }
    public function trash($tablename)
    {
        $data = $this->model::onlyTrashed()->get();
        return view('Dashboard::admin.crud.index', [
            'trash'          => true,
            'data'           => $data,
            'tablename'      => $this->tablename,
            'table'          => $this->table,
            'inputs'         => $this->inputs,
            '__admin_active' => 'admin.crud.' . $this->tablename
        ]);
    }
    public function restore($tablename, $id)
    {
        $item = $this->model::withTrashed()->findOrFail($id);
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.crud.trash', ['tablename' => $tablename])->with('success', 'Se ha restaurado un <strong>item</strong> con éxito.');
    }
    public function copy($tablename, $id)
    {
        $new = $this->model::findOrFail($id)->replicate();
        $new->save();
        return redirect()->route('admin.crud.edit', ['tablename' => $tablename, 'id' => $new->id])->with('success', 'Se ha duplicado un <strong>item</strong> con éxito.');
    }
}
