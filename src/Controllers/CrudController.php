<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\Content;
use AporteWeb\Dashboard\Models\ContentMeta;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Gallery;
use AporteWeb\Dashboard\Models\Multimedia;

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
        $content   = null;
        $relations = [];
        $galleries = [];
        $subForm   = [];
        $item      = null;
        foreach (LaravelLocalization::getLocalesOrder() as $key => $value) {
            $languages[$key] = $value['name'];
        }
        if ($id) {
            $item = $this->model::where('id', $id)->firstOrFail();
            foreach ($this->inputs as $inputKey => $input) {
                $content[$input->columnname] = $item->{$input->columnname};
            }
            if ($input->type == 'map-select-lat-lng') {
                $content[$input->columnname . '_lat'] = $item->{$input->columnname . '_lat'};
                $content[$input->columnname . '_lng'] = $item->{$input->columnname . '_lng'};
            }
        }

        foreach ($this->inputs as $inputKey => $input) {

            if ($input->type == 'select' && $input->valueoriginselector == 'table') {
                $relations[$input->tabledata] = DB::table($input->tabledata)->pluck($input->tabletextcolumn, $input->tablekeycolumn);
            }

            if ($input->type == 'gallery' && $item) {
                $galleries[$input->columnname] = [];
                $gallery = Gallery::find($item->{$input->columnname});
                if ($gallery) {
                    foreach ($gallery->items as $key => $item) {
                        $galleries[$input->columnname][] = [
                            'url'  => asset(Storage::url($item->path)),
                            'path' => $item->path,
                            'id'   => $item->id,
                            'type' => Storage::mimeType($item->path)
                        ];
                    }
                }
            }
            if ($input->type == 'subForm') {
                $dirPath  = app_path('Dashboard');
                $filePath = $dirPath . '/' . $input->tabledata . '.json';

                $className = str_replace(['_', '-', '.'], ' ', $input->tabledata);
                $className = ucwords($className);
                $className = str_replace(' ', '', $className);
                $subModel = "\\App\\Models\\" . $className;

                if (file_exists($filePath)) {
                    $subFormLayout      = json_decode(file_get_contents($filePath));
                    $subForm[$input->columnname] = [
                        'table'  => $subFormLayout->table,
                        'inputs' => $subFormLayout->inputs
                    ];

                    if ($id) {
                        $subForm[$input->columnname]['content'] = $subModel::where($input->tablekeycolumn, $item->id)->get();
                    }            
                }
                // $input->tablekeycolumn id para buscar
            }

        }    
        return response()->json([
            'languages' => $languages,
            'locale'    => App::getLocale(),
            'tablename' => $this->tablename,
            'table'     => $this->table,
            'inputs'    => $this->inputs,
            'relations' => $relations,
            'subForm'   => $subForm,
            'galleries' => $galleries,
            'content'   => $content
        ]);
    }

    public function index()
    {
        // $data = $this->model::paginate(20);
        $data = $this->model::get();
        return view('Dashboard::admin.crud.index', [
            'data'           => $data,
            'tablename'      => $this->tablename,
            'table'          => $this->table,
            'inputs'         => $this->inputs,
            '__admin_active' => 'admin.crud-' . $this->tablename
        ]);
    }

    public function create()
    {
        return view('Dashboard::admin.crud.create', [
            'tablename'      => $this->tablename,
            'table'          => $this->table,
            'inputs'         => $this->inputs,
            '__admin_active' => 'admin.crud-' . $this->tablename
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
            if ($input->type == 'card-header' || $input->type == 'gallery') {
                continue;
            }
            if($input->validate == 1) {
                if($input->nullable == "0"){
                    $validHelper = [ $input->columnname => 'required' ];
                }
            }
        }

        $validatedData = $request->validate($validHelper);

        $subForm = json_decode($request->subForm, true);
        foreach ($this->inputs as $inputKey => $input) {
            if ($input->type == 'card-header') {
                continue;
            }

            if ($input->type == 'map-select-lat-lng') {
                $item->{$input->columnname . '_lat'} = $request->{$input->columnname . '_lat'};
                $item->{$input->columnname . '_lng'} = $request->{$input->columnname . '_lng'};
                $item->save();
                continue;
            }

            if ($input->type != 'subForm' && $input->type != 'gallery') {
                $item->{$input->columnname} = $request->{$input->columnname};
            }


            if ($input->type == 'gallery') {
                // Gallery
                // 
                if ($item->{$input->columnname}) {
                    $gallery = Gallery::where('id', $item->{$input->columnname})->firstOrNew();
                } else {
                    $gallery = new Gallery;
                }
                $gallery->description       = $this->tablename . ' gallery' . $item->id;
                $gallery->save();

                $item->{$input->columnname} = $gallery->id;
                $item->save();

                $ids = [];
                foreach ($request->{$input->columnname} as $key => $value) {
                    if(is_string($value)) {
                        $ids[$value] = [ 'order' => $key ];
                    } else {
                        $path = $value->store('public/content/' . $this->tablename . '/');
                        $multimedia = new Multimedia;
                        $multimedia->path          = $path;
                        $multimedia->order         = null;
                        $multimedia->filename      = null;
                        $multimedia->alt           = null;
                        $multimedia->caption       = null;
                        $multimedia->original_name = null;
                        $multimedia->disk          = null;
                        $multimedia->meta_value    = null;
                        $multimedia->save();
                        $ids[$multimedia->id] = [ 'order' => $key ];
                    }
                }
                $gallery->items()->sync($ids);
            }

            if ($input->type == 'subForm') {
                
                $dirPath  = app_path('Dashboard');
                $filePath = $dirPath . '/' . $input->tabledata . '.json';
    
                if (file_exists($filePath)) {
                    $content   = json_decode(file_get_contents($filePath));
                    $subTable  = $content->table;
                    $subInputs = $content->inputs;
                }
    
                $className = str_replace(['_', '-', '.'], ' ', $input->tabledata);
                $className = ucwords($className);
                $className = str_replace(' ', '', $className);
                $subModel = "\\App\\Models\\" . $className;

                foreach ($subForm[$input->columnname] as $subFormItem) {
                    if ($subFormItem->type == 'card-header') {
                        continue;
                    }        
                    if ( array_key_exists('id', $subFormItem) ) {
                        $subItem = $subModel::find($subFormItem['id']);
                    } else {
                        $subItem = new $subModel;
                    }
                    foreach ($subInputs as $subInputKey => $subInput) {
                        if ($subInput->type != 'subForm') {
                            $subItem->{$subInput->columnname} = $subFormItem[$subInput->columnname];
                        }
                        $subItem->{$input->tablekeycolumn} = $item->id;
                    }
                    $subItem->save();
                }

            }
        }

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
            '__admin_active' => 'admin.crud-' . $this->tablename
        ]);
    }

    public function destroy($tablename, $id)
    {
        $item = $this->model::find($id);
        $item->delete();
        return redirect()->route('admin.crud', ['tablename' => $tablename, 'id' => $item->id])->with('status', 'Se elimino un <strong>item</strong> con éxito.');
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
            '__admin_active' => 'admin.crud-' . $this->tablename
        ]);
    }
    public function restore($tablename, $id)
    {
        $item = $this->model::withTrashed()->find($id);
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.crud.trash', ['tablename' => $tablename])->with('success', 'Se ha restaurado un <strong>item</strong> con éxito.');
    }
    public function copy($tablename, $id)
    {
        $new = $this->model::find($id)->replicate();
        foreach ($this->inputs as $inputKey => $input) {

            if ($input->type == 'select' && $input->valueoriginselector == 'table') {}

            if ($input->type == 'gallery') {
                $new->{$input->columnname} = NULL;
            }
            if ($input->type == 'subForm') {}
        }
        $new->save();
        return redirect()->route('admin.crud.edit', ['tablename' => $tablename, 'id' => $new->id])->with('success', 'Se ha duplicado un <strong>item</strong> con éxito.');
    }
}
