<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use AporteWeb\Dashboard\Requests\GroupCreateRequest;
use AporteWeb\Dashboard\Requests\GroupEditRequest;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\User;
use Junges\ACL\Http\Models\Group;
use Junges\ACL\Http\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use AporteWeb\Dashboard\Generators\Generator;
use Illuminate\Support\Facades\Artisan;

class CrudGeneratorController extends Controller
{
    public function index()
    {
        $dirPath = __crudFolder();
        $data = File::allFiles($dirPath);
        
        return view('Dashboard::admin.crud-generator.index', [
            'data'           => $data,
            '__admin_active' => 'admin.crud-generator'
        ]);
    }

    public function data($table = false)
    {
        $languages = [];
        $content = null;
        if($table) {
            $dirPath  = app_path('Dashboard');
            $filePath = $dirPath . '/' . $table . '.json';
            if (file_exists($filePath)) {
                $content = json_decode(file_get_contents($filePath));
            }
        }
        foreach (LaravelLocalization::getLocalesOrder() as $key => $value) {
            $languages[$key] = $value['name'];
        }
        return response()->json([
            'content'   => $content,
            'languages' => $languages,
        ]);
    }

    public function create()
    {
        return view('Dashboard::admin.crud-generator.create', [
            '__admin_active' => 'admin.crud-generator'
        ]);
    }

    public function store(Request $request)
    {
        $dirPath = __crudFolder();

        $data     = json_decode($request->data);
        $filePath = $dirPath . '/' . $data->table->tablename . '.json';
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

        DB::table('permissions')->upsert([
            [
                'name'        => 'Crear ' . $data->table->name->{App::getLocale()},
                'slug'        => $data->table->tablename . '-create',
                'description' => ''
            ],
            [
                'name'        => 'Editar ' . $data->table->name->{App::getLocale()},
                'slug'        => $data->table->tablename . '-edit',
                'description' => ''
            ],
            [
                'name'        => 'Eliminar ' . $data->table->name->{App::getLocale()},
                'slug'        => $data->table->tablename . '-delete',
                'description' => ''
            ],
            [
                'name'        => 'Restaurar ' . $data->table->name->{App::getLocale()},
                'slug'        => $data->table->tablename . '-restore',
                'description' => ''
            ]
        ], ['slug'], ['name', 'description']);

        (new Generator($data->table, $data->inputs))->crud();
        return Artisan::call('migrate:refresh --path=vendor/aporteweb/dashboard/src/migrations/2020_11_23_000001_generate_crud_tables.php');
        return 1;
        return redirect()->route('admin.crud-generator')->with('success', 'Se añadio un <strong>Groupo</strong> con éxito.');
    }

    public function edit($table)
    {
        return view('Dashboard::admin.crud-generator.edit', [
            'table'          => $table,
            '__admin_active' => 'admin.crud-generator'
        ]);
    }

    public function destroy($id)
    {
        Group::find($id)->delete();
        return redirect()->route('admin.crud-generator')->with('success', 'Se ha eliminado un <strong>Groupo</strong> con éxito.');
    }
    public function trash()
    {
        $data = Group::onlyTrashed()->get();
        return view('Dashboard::admin.crud-generator.index', [
            'data'           => $data,
            'trash'          => true,
            '__admin_active' => 'admin.crud-generator'
        ]);
    }
    public function restore($id)
    {
        $item = Group::withTrashed()->find($id);
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.crud-generator.trash')->with('success', 'Se ha restaurado un <strong>Groupo</strong> con éxito.');
    }
}
