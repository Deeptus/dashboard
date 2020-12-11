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

            $className = str_replace(['_', '-', '.'], ' ', $this->tablename);
            $className = ucwords($className);
            $className = str_replace(' ', '', $className);
            $this->model = "\\App\\Models\\" . $className;
        }

    }

    public function data($tablename, $id = false)
    {
        $languages = [];
        $content = null;
        $relations = [];
        foreach (LaravelLocalization::getLocalesOrder() as $key => $value) {
            $languages[$key] = $value['name'];
        }
        if ($id) {
            $item = $this->model::where('id', $id)->firstOrFail();
            foreach ($this->inputs as $inputKey => $input) {
                $content[$input->columnname] = $item->{$input->columnname};
            }    
        }

        foreach ($this->inputs as $inputKey => $input) {
            
            if ($input->type == 'select' && $input->valueoriginselector == 'table') {
                $relations[$input->tabledata] = DB::table($input->tabledata)->pluck($input->tabletextcolumn, $input->tablekeycolumn);
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
        $data = $this->model::paginate(20);
        return view('Dashboard::admin.crud.index', [
            'data'           => $data,
            'tablename'      => $this->tablename,
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

        $validHelper = [];

        if($id){
            $item       = $this->model::where('id', $id)->firstOrFail();
            $action     = 'edito';
        } else {
            $item       = new $this->model;
            $action     = 'añadio';
        }

        foreach ($this->inputs as $inputKey => $input) {

           

            if($input->nullable == 0){
                $validHelper = [ $input->columnname => 'required' ];
            }


           
           
        }

        $validatedData = $request->validate($validHelper);

        foreach ($this->inputs as $inputKey => $input) {

            //echo $input->columnname;

           $item->{$input->columnname} = $request->{$input->columnname};
        }
        $item->save();

        return response()->json(['message' => 'Se ' . $action . ' un <strong>Usuario</strong> con éxito.']);
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
        $item = $this->model::find($id);
        $item->delete();
        return redirect()->route('Dashboard::admin.crud', ['tablename' => $tablename, 'id' => $item->id])->with('status', 'Se elimino un <strong>item</strong> con éxito.');
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
        $item = $this->model::withTrashed()->find($id);
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('Dashboard::admin.crud.trash', ['tablename' => $tablename])->with('success', 'Se ha restaurado un <strong>item</strong> con éxito.');
    }
    public function copy($tablename, $id)
    {
        $new = $this->model::find($id)->replicate();
        $new->save();
        return redirect()->route('Dashboard::admin.crud.edit', ['tablename' => $tablename, 'id' => $new->id])->with('success', 'Se ha duplicado un <strong>item</strong> con éxito.');
    }
}
