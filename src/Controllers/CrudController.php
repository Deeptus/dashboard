<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\Content;
use AporteWeb\Dashboard\Models\ContentMeta;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Gallery;
use AporteWeb\Dashboard\Models\Multimedia;
use Illuminate\Support\Facades\Schema;

class CrudController extends Controller
{
    private $model;
    private $tablename;
    private $table;
    private $inputs;
    private $conditions;

    public function __construct()
    {
        $this->middleware('auth');
        if (!app()->runningInConsole()) {
            $this->tablename = request()->route()->parameters()['tablename'];
    
            if($this->tablename) {
                $dirPath  = app_path('Dashboard');
                $filePath = $dirPath . '/' . $this->tablename . '.json';
    
                if (file_exists($filePath)) {
                    $content          = json_decode(file_get_contents($filePath));
                    $this->table      = $content->table;
                    $this->inputs     = $content->inputs;
                    $this->conditions = $content->conditions;
                }
    
                $className = str_replace(['_', '-', '.'], ' ', $this->tablename);
                $className = ucwords($className);
                $className = str_replace(' ', '', $className);
                $this->model = "\\App\\Models\\" . $className;
            }
        }

    }
    public function getInput($id, $input, $content, $relations, $galleries, $subForm, $item) {

        $found = false;

        if ($input->type == 'select' && $input->valueoriginselector == 'table') {
            $found = true;
            $relations[$input->tabledata] = DB::table($input->tabledata)->whereNull('deleted_at')->pluck($input->tabletextcolumn, $input->tablekeycolumn);
            if ($item) {
                $content[$input->columnname] = $item->{$input->columnname};
            }
        }

        if ($input->type == 'checkbox' && $input->valueoriginselector == 'table') {
            $found = true;
            $relations[$input->tabledata] = DB::table($input->tabledata)->whereNull('deleted_at')->pluck($input->tabletextcolumn, $input->tablekeycolumn);
            if ($item) {
                $pivot_name = $this->tablename.'_'.$input->tabledata.'_'.$input->columnname;
                $content[$input->columnname] = DB::table($pivot_name)->where($this->tablename.'_id', $item->id)->pluck($input->tabledata.'_id')->toArray();
            } else {
                $content[$input->columnname] = [];
            }
        }

        if ($input->type == 'map-select-lat-lng') {
            $found = true;
            try {
                $content[$input->columnname . '_lat'] = $item->{$input->columnname . '_lat'};
                $content[$input->columnname . '_lng'] = $item->{$input->columnname . '_lng'};
            } catch (\Throwable $th) {
                $content[$input->columnname . '_lat'] = null;
                $content[$input->columnname . '_lng'] = null;
            }
        }

        if ($input->type == 'multimedia_file') {
            $found = true;
            if ($item) {
                $file = Multimedia::find($item->{$input->columnname . '_id'});
                if ($file) {
                    $content[$input->columnname] = [
                        'url'  => asset(Storage::url($file->path)),
                        'path' => $file->path,
                        'id'   => $file->id,
                        'type' => Storage::mimeType($file->path)
                    ];
                }
            }
        }

        if ($input->type == 'gallery' && $item) {
            $found = true;
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
            $found = true;
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

                foreach ($subFormLayout->inputs as $subInputKey => $subInput) {
                    $results = $this->getInput(
                        false, // ID false
                        $subInput,
                        null,
                        $relations,
                        $galleries,
                        $subForm,
                        null
                    );
                    // $input     = $results['input'];
                    // $content   = $results['content'];
                    $relations = $results['relations'];
                    $galleries = $results['galleries'];
                    $subForm   = $results['subForm'];
                }        
                if ($id) {
                    $subItems = $subModel::where($input->tablekeycolumn, $item->id);
                    if (Schema::hasColumn($subFormLayout->table->tablename, 'order_index')) {
                        $subItems = $subItems->orderBy('order_index', 'asc');
                    }
                    $subForm[$input->columnname]['content'] = $subItems->get();
                    foreach ($subForm[$input->columnname]['content'] as $itemKey => $item) {
                        foreach ($subFormLayout->inputs as $subkKy => $subInputs) {
                            if ($subInputs->type == 'multimedia_file') {
                                $file = Multimedia::find($item->{$subInputs->columnname . '_id'});
                                if ($file) {
                                    $subForm[$input->columnname]['content'][$itemKey]->{$subInputs->columnname} = [
                                        'url'  => asset(Storage::url($file->path)),
                                        'path' => $file->path,
                                        'id'   => $file->id,
                                        'type' => Storage::mimeType($file->path)
                                    ];
                                }                    
                            }
                        }
                    }
                }            
            }
            // $input->tablekeycolumn id para buscar
        }
        if (!$found && $item) {
            try {
                if($input->translatable) {
                    $content[$input->columnname] = $item->getTranslations($input->columnname);
                } else {
                    $content[$input->columnname] = $item->{$input->columnname};
                }
            } catch (\Throwable $th) {
                //throw $th;
                $content[$input->columnname] = $item->{$input->columnname};
            }
        }
        return [
            'input'     => $input,
            'content'   => $content,
            'relations' => $relations,
            'galleries' => $galleries,
            'subForm'   => $subForm,
        ];
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
            $item = $this->model::findByPKOrFail($id);
        }

        foreach ($this->inputs as $inputKey => $input) {
            $results = $this->getInput(
                $id,
                $input,
                $content,
                $relations,
                $galleries,
                $subForm,
                $item
            );
            $input     = $results['input'];
            $content   = $results['content'];
            $relations = $results['relations'];
            $galleries = $results['galleries'];
            $subForm   = $results['subForm'];
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
        $appends = [];
        $data = new $this->model;
        if (intval($this->table->single_record)) {
            $item = $data->first();
            if ($item) {
                return view('Dashboard::admin.crud.edit', [
                    'item'           => $item,
                    'tablename'      => $this->tablename,
                    'table'          => $this->table,
                    'inputs'         => $this->inputs,
                    '__admin_active' => 'admin.crud-' . $this->tablename
                ]);
            } else {
                return view('Dashboard::admin.crud.create', [
                    'tablename'      => $this->tablename,
                    'table'          => $this->table,
                    'inputs'         => $this->inputs,
                    '__admin_active' => 'admin.crud-' . $this->tablename
                ]);
            }
        }
        foreach ($this->conditions as $key => $condition) {
            $data = $data->whereRaw($condition->condition);
        }
        if (request()->has('s')) {
            $appends['s'] = request()->s;
            $cols = \DB::getSchemaBuilder()->getColumnListing((new $this->model)->getTable());
            $data = $data->where(function ($query) use ($cols) {
                foreach ($cols as $col) {
                    $query->orWhere($col, 'like', '%'.request()->s.'%');
                }
            });
        }
        if (request()->has('paginate')) {
            $data = $data->paginate(request()->paginate);
            $appends['paginate'] = request()->paginate;
        } else {
            $data = $data->paginate(20);
        }
        $data->appends($appends);
        // $data = $data->toSql();
        // dd($data);
        // 😒
        // $data = $this->model::get();
        // return response()->json($this->model::first());
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
    public function attachInput($item, $input, $data)
    {
        try {
            if ($input->type == 'card-header') {
                return true;
            }
        } catch (\Throwable $th) {
            dd($input);
        }

        if ($input->type == 'checkbox') {
            $item->save();
            $pivot_name = $this->tablename.'_'.$input->tabledata.'_'.$input->columnname;
            DB::table($pivot_name)->where($this->tablename.'_id', $item->id)->delete();
            foreach (explode(',', $data[$input->columnname]) as $key => $value) {
                DB::table($pivot_name)->insert([
                    $this->tablename.'_id'  => $item->id,
                    $input->tabledata.'_id' => $value
                ]);
            }
            return true;
        }
        
        if ($input->type == 'map-select-lat-lng') {
            $item->{$input->columnname . '_lat'} = $data[$input->columnname . '_lat'];
            $item->{$input->columnname . '_lng'} = $data[$input->columnname . '_lng'];
            $item->save();
            return true;
        }

        if ($input->type == 'multimedia_file') {
            try {
                if ($data[$input->columnname]->isValid()) {
                    $path = $data[$input->columnname]->store('public/content/' . $this->tablename . '/');
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
                    $item->{$input->columnname . '_id'} = $multimedia->id;
                    $item->save();
                }
            } catch (\Throwable $th) {
                if ( is_integer(intval($data[$input->columnname])) && intval($data[$input->columnname]) > 0) {
                    $item->{$input->columnname . '_id'} = intval($data[$input->columnname]);
                }
            }
            return true;
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
            if (array_key_exists($input->columnname, $data) && is_array($data[$input->columnname])) {
                foreach ($data[$input->columnname] as $key => $value) {
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
            return true;
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
            try {
                //
                // By AleSosa 🤦‍♂️
                $item->save();
                // dd([$input->tablekeycolumn, $item->id]);
                // $subModel::where(''.$input->tablekeycolumn.'', $item->id)->delete();
                $subModel::where($input->tablekeycolumn, $item->id)->delete();
                if (array_key_exists($input->columnname, $data)) {
                    foreach ($data[$input->columnname] as $subFormKey =>  $subFormItem) {
                        if ( array_key_exists('id', $subFormItem) ) {
                            $subItem = $subModel::withTrashed()->find($subFormItem['id']);
                        } else {
                            $subItem = new $subModel;
                        }
                        if (Schema::hasColumn($subTable->tablename, 'order_index')) {
                            $subItem->order_index = $subFormKey;
                        }
                        foreach ($subInputs as $subInputKey => $subInput) {
                            $subFormItem[$input->tablekeycolumn] = $item->id;
                            $this->attachInput($subItem, $subInput, $subFormItem);
                        }
                        $subItem->deleted_at = null;
                        $subItem->save();
                    }
                }
            } catch (\Throwable $th) {
                dd($th);
                // dd($data);
            }

            return true;
        }
        if ($input->type == 'password') {
            $item->{$input->columnname} = bcrypt($data[$input->columnname]);
            $item->save();
            return true;
        }
        try {
            if($input->translatable) {
                $item->setTranslations($input->columnname, json_decode($data[$input->columnname], true));
            } else {
                $item->{$input->columnname} = $data[$input->columnname];
            }
        } catch (\Throwable $th) {
            $item->{$input->columnname} = $data[$input->columnname];
        }        
    }
    public function store(Request $request, $tablename, $id = false)
    {
        if($id){
            $item       = $this->model::findByPKOrFail($id);
            $action     = 'edito';
        } else {
            $item       = new $this->model;
            $action     = 'añadio';
        }
        /*
        *** VALIDACION POR AHORA SIN FUNCIONAR POR REVISION FALTANTE A SUBFORM ***
        $validHelper = [];
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
        */

        foreach ($this->inputs as $inputKey => $input) {
            try {
                if ($input->type != 'card-header' && $input->settable == 0) {
                    $this->attachInput($item, $input, $request->all());
                }
            } catch (\Throwable $th) {
                abort(500, json_encode([$input, $th]));
            }
        }
        try {
            if ($this->table->slug == 1 && ( $item->slug == null || $item->slug == '' ) ) {
                $slug = Str::slug($request->{$this->table->slug_col} . ' ' . Str::random(6));
                $item->slug = $slug;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        $item->save();
        return response()->json(['message' => 'Se ' . $action . ' un <strong>Usuario</strong> con éxito.']);
    }

    public function edit($tablename, $id)
    {
        $item = $this->model::findByPKOrFail($id);
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
        $item = $this->model::findByPK($id);
        $item->delete();
        return redirect()->route('admin.crud', ['tablename' => $tablename])->with('status', 'Se elimino un <strong>item</strong> con éxito.');
    }
    public function trash($tablename)
    {
        $data = $this->model::onlyTrashed()->paginate(20);
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
        $item = $this->model::withTrashed()->findByPK($id)->first();
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.crud.trash', ['tablename' => $tablename])->with('success', 'Se ha restaurado un <strong>item</strong> con éxito.');
    }
    public function copy($tablename, $id)
    {
        $new = $this->model::findByPK($id)->replicate();
        foreach ($this->inputs as $inputKey => $input) {

            if ($input->type == 'select' && $input->valueoriginselector == 'table') {}

            if ($input->type == 'gallery') {
                $new->{$input->columnname} = NULL;
            }
            if ($input->type == 'subForm') {}
        }
        try {
            if ( $this->table->slug == 1 ) {
                $slug = Str::slug($new->{$this->table->slug_col} . ' ' . Str::random(6));
                $new->slug = $slug;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        $new->save();
        return redirect()->route('admin.crud.edit', ['tablename' => $tablename, 'id' => $new->pkv])->with('success', 'Se ha duplicado un <strong>item</strong> con éxito.');
    }
}
