<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use AporteWeb\Dashboard\Requests\GroupCreateRequest;
use AporteWeb\Dashboard\Requests\GroupEditRequest;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\User;
use Junges\ACL\Models\Group;
use Junges\ACL\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use AporteWeb\Dashboard\Generators\Generator;
use Illuminate\Support\Facades\Artisan;

use  Illuminate\Pagination\Paginator;
use  Illuminate\Pagination\LengthAwarePaginator;
use  Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;

class CrudGeneratorController extends Controller {

    public function paginate($items, $perPage = 15, $page = null, $options = []) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function index() {
        $dirPath = __crudFolder();
        $data = collect(File::allFiles($dirPath))->map(function ($file) {
            $fileName = $file->getRelativePathname();
            // get file type
            $fileType = File::extension($fileName);
            $menu     = $fileType == 'json' ? 'crud' : null;
            $fileName = str_replace('.php', '', $fileName);
            //$fileName = str_replace('-', ' ', $fileName);
            //$fileName = ucwords($fileName);
            return [
                'name' => $fileName,
                'path' => $file->getRelativePathname(),
                'fullPath' => $file->getPathname(),
                'extension' => $file->getExtension(),
                'size' => $file->getSize(),
                'last_modified' => $file->getMTime(),
                'last_modified_formatted' => date('d/m/Y H:i:s', $file->getMTime()),
                'created_at' => $file->getCTime(),
                'created_at_formatted' => date('d/m/Y H:i:s', $file->getCTime()),
                'table_exist' => Schema::hasTable(strtolower(str_replace('.json', '', $fileName))),
                'menu' => $menu,
            ];
        });
        if ( request()->has('s') && request()->get('s') != '' ) {
            $data = $data->filter(function ($item) {
                return Str::contains($item['name'], request()->get('s'));
            });
        }
        $data = $this->paginate($data, request()->paginate ?? 15, null, ['path' => 'crud-generator', 'query' => ['s' => request()->s, 'paginate' => request()->paginate]]);

        return view('Dashboard::admin.crud-generator.index', [
            'data'           => $data,
            '__admin_active' => 'admin.crud-generator'
        ]);
    }
    public function fix($tablename = false) {
        $dirPath  = app_path('Dashboard');
        $filePath = $dirPath . '/' . $tablename . '.json';

        if (file_exists($filePath)) {
            $content    = json_decode(file_get_contents($filePath));
            $table      = $content->table;
            $inputs     = $content->inputs;
            $conditions = $content->conditions;
        }
        $className = str_replace(['_', '-', '.'], ' ', $tablename);
        $className = ucwords($className);
        $className = str_replace(' ', '', $className);
        $model = "\\App\\Models\\" . $className;
        if ( property_exists($table, 'model') && $table->model ) { 
            $model = $table->model;
        }
        foreach ($model::get() as $key => $item) {
            if ($item->uuid == null || $item->uuid == '') {
                $item->uuid = __uuid();
            }
            if ($table->slug == 1 && ( $item->slug == null || $item->slug == '' ) ) {
                $slug = Str::slug($item->{$table->slug_col} . ' ' . Str::random(6));
                $item->slug = $slug;
            }
            $item->save();
        }
        return redirect()->back()->with('success', 'Fix Success');
    }
    public function data($table = false) {
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

    public function create() {
        return view('Dashboard::admin.crud-generator.create', [
            '__admin_active' => 'admin.crud-generator'
        ]);
    }

    public function store(Request $request) {
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
        return Artisan::call('migrate:refresh --path=vendor/aporteweb/dashboard/src/migrations/9999_12_31_000001_generate_crud_tables.php');
        return 1;
        return redirect()->route('admin.crud-generator')->with('success', 'Se añadio un <strong>Groupo</strong> con éxito.');
    }

    public function edit($table) {
        return view('Dashboard::admin.crud-generator.edit', [
            'table'          => $table,
            '__admin_active' => 'admin.crud-generator'
        ]);
    }

    public function destroy($id) {
        Group::find($id)->delete();
        return redirect()->route('admin.crud-generator')->with('success', 'Se ha eliminado un <strong>Groupo</strong> con éxito.');
    }
    public function trash() {
        $data = Group::onlyTrashed()->get();
        return view('Dashboard::admin.crud-generator.index', [
            'data'           => $data,
            'trash'          => true,
            '__admin_active' => 'admin.crud-generator'
        ]);
    }
    public function restore($id) {
        $item = Group::withTrashed()->find($id);
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.crud-generator.trash')->with('success', 'Se ha restaurado un <strong>Groupo</strong> con éxito.');
    }
    public function listTables() {
        return DB::connection()->getDoctrineSchemaManager()->listTableNames();
    }
    public function tableInfo() {
        // Obtener información de la tabla, entre ella el comentario
        $table = DB::connection()->getDoctrineSchemaManager()->listTableDetails(request('table'));
        // $table->getColumns(): tambien trae las columnas pero con mas informacion
        $columns = Schema::getColumnListing(request()->table);
        $table = [
            'info' => [
                'name' => request()->table,
                'comment' => $table->getComment(),
            ],
            'columns' => []
        ];
        foreach ($columns as $columnName) {
            $column = Schema::getConnection()->getDoctrineColumn(request()->table, $columnName);
            $table['columns'][] = [
                'name'      => $column->getName(),
                'notnull'   => $column->getNotnull(),
                'default'   => $column->getDefault(), 
                'type'      => $column->getType()->getName(), 
                'scale'     => $column->getScale(), 
                'precision' => $column->getPrecision(), 
                'length'    => $column->getLength()
            ];
        }
        return $table;

        return DB::select('describe ' . request()->table);
        return DB::connection()->getDoctrineColumn(request()->table, 'name')->getType()->getName();
    }
    public function seedGenerate($tablename = false) {
        define('STDIN',fopen("php://stdin","r"));
        $exitCode = Artisan::call('iseed ' . $tablename);
        return redirect()->back()->with('success', 'Seed Generated: <strong>' . $tablename . '</strong>');
    }
    public function seedRestore($tablename) {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table($tablename)->truncate();
        $exitCode = Artisan::call('db:seed --class=' . Str::studly($tablename) . 'TableSeeder');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return redirect()->back()->with('success', 'Seed Restored: <strong>' . $tablename . '</strong>');
    }
}
