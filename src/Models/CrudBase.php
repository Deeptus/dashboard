<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Gallery;
use AporteWeb\Dashboard\Models\Multimedia;
use Illuminate\Support\Facades\Storage;

trait CrudBase {

    public $listEnableMethods = [];
    public $translatable = [];

    public function __construct() {
        $dirPath  = app_path('Dashboard');
        $filePath = $dirPath . '/' . $this->table . '.json';
        
        if (file_exists($filePath)) {
            $content = json_decode(file_get_contents($filePath));
            $table   = $content->table;
            foreach ($content->inputs as $key => $input) {
                try {
                    if ($table->translation_method == "spatie-laravel-translatable") {
                        if($input->translatable == 1) {
                            $this->translatable[] = $input->columnname;
                        }
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
                if ($input->type == 'gallery') {
                    $methodName = str_replace(['_', '-', '.'], ' ', $input->columnname . '_rel_val');
                    $methodName = ucwords($methodName);
                    $methodName = 'get' . str_replace(' ', '', $methodName) . 'Attribute';
                    
                    $barFunc = function () use ($input) {
                        $gallery = Gallery::with(['items'])->find($this->{$input->columnname});
                        if ($gallery) {
                            return $gallery->items;
                        }
                    };
                    $this->listEnableMethods[$methodName] = \Closure::bind($barFunc, $this, get_class());
                }
            }
        }
        return parent::__construct();
    }

    function __call($method, $args) {
        if ($method == 'findByPK') {
            $condition = $this->getConnection()
                ->getSchemaBuilder()
                ->hasColumn($this->getTable(), 'uuid');
            if ($condition) {
                return $this->firstWhere('uuid', $args[0]);
            }
        }
        if ($method == 'findByPKOrFail') {
            $condition = $this->getConnection()
            ->getSchemaBuilder()
            ->hasColumn($this->getTable(), 'uuid');
            if ($condition) {
                $result = $this->firstWhere('uuid', $args[0]);
                if ($result) {
                    return $result;
                } else {
                    $result = $this->firstWhere('id', $args[0]);
                    if ($result) {
                        return $result;
                    }
                }
                abort(404);
            }
        }

        if (array_key_exists($method, $this->listEnableMethods)) {
            if(is_callable($this->listEnableMethods[$method])) {
                return call_user_func_array($this->listEnableMethods[$method], $args);
            }
        } else {
            return parent::__call($method, $args);
        }
    }

    public function __get($key) {
        $dirPath  = app_path('Dashboard');
        $filePath = $dirPath . '/' . $this->table . '.json';

        if (!$this->getAttribute($key)) {
            if (file_exists($filePath)) {
                $content = json_decode(file_get_contents($filePath));
                $table   = $content->table;
                $input = array_filter(
                    $content->inputs,
                    function ($e) use (&$key) {
                        return $e->columnname == $key;
                    }
                );
                $input = array_shift($input);
                if ($input && $input->type == 'checkbox') {
                    $pivot_name = $content->table->tablename.'_'.$input->tabledata.'_'.$input->columnname;
                    $ids = DB::table($pivot_name)->where($content->table->tablename.'_id', $this->id)->pluck($input->tabledata.'_id')->toArray();
                    return $ids;
                }
                if ($input && $input->type == 'subForm') {
                    $className = str_replace(['_', '-', '.'], ' ', $input->tabledata);
                    $className = ucwords($className);
                    $className = str_replace(' ', '', $className);
                    $subModel = "\\App\\Models\\" . $className;
                    return $subModel::where($input->tablekeycolumn, $this->id)->orderBy('order_index')->get();
                }
                if ($input && $input->type == 'multimedia_file') {
                    $file = Multimedia::find($this->{$input->columnname . '_id'});
                    $image = [
                        'url'  => null,
                        'path' => null,
                        'id'   => null,
                        'type' => null
                    ];
                    if ($file) {
                        if (Storage::exists($file->path)) {
                            try {
                                $image = [
                                    'url'  => asset(Storage::url($file->path)),
                                    'path' => $file->path,
                                    'id'   => $file->id,
                                    // Multimedia deberia tener un campo Multimedia
                                    'uuid' => $file->uuid,
                                    'type' => Storage::mimeType($file->path),
                                    'original_name' => $file->original_name,
                                ];
                                if ( $file->original_name && strlen($file->original_name) > 0 ) {
                                    $image['download_url'] = route('admin.multimedia.download', ['id' => $file->id, 'original_name' => $file->original_name]);
                                    $image['stream_url']   = route('admin.multimedia.stream',   ['id' => $file->id, 'original_name' => $file->original_name]);
                                }
                            } catch (\Throwable $th) {
                            }
                        }
                    }
                    return $image;
                }
                /*
                if ($input && $input->type == 'gallery') {
                    $file = Multimedia::find($this->{$input->columnname . '_id'});
                    $image = [
                        'url'  => null,
                        'path' => null,
                        'id'   => null,
                        'type' => null
                    ];
                    if ($file) {
                        if (Storage::exists($file->path)) {
                            $image = [
                                'url'  => asset(Storage::url($file->path)),
                                'path' => $file->path,
                                'id'   => $file->id,
                                'type' => Storage::mimeType($file->path)
                            ];
                        }
                    }
                    return $image;
                }
                */
            }
        }

        if (Str::endsWith($key, '_rel_val')) {
            return $this->getRelationCrud($key, $filePath, 'value');
        }
        if (Str::endsWith($key, '_rel')) {
            return $this->getRelationCrud($key, $filePath, 'relation');
        }
        return $this->getAttribute($key);
    }

    public function getRelationCrud($key, $filePath, $type) {
        if ($type == 'relation') {
            $column = str_replace('_rel', '', $key);
        } else {
            $column = str_replace('_rel_val', '', $key);
        }
        if (file_exists($filePath)) {
            $content = json_decode(file_get_contents($filePath));
            $table   = $content->table;
            $input = array_filter(
                $content->inputs,
                function ($e) use (&$column) {
                    return $e->columnname == $column;
                }
            );
            
            $input = array_shift($input);
            if ($input && $input->type == 'checkbox') {
                // return $input;
                $pivot_name = $content->table->tablename.'_'.$input->tabledata.'_'.$input->columnname;
                $ids = DB::table($pivot_name)->where($content->table->tablename.'_id', $this->id)->pluck($input->tabledata.'_id')->toArray();
                $items = DB::table($input->tabledata)->whereIn($input->tablekeycolumn, $ids)->get();
                return $items;
            }
            if (!$this->getAttribute($column)) {
                return '';
            }

            if ($input->type == 'select' || $input->type == 'select_string') {
                if ($input->valueoriginselector == 'values') {
                    $option = array_filter(
                        $input->options,
                        function ($e) use (&$column) {
                            return $e->key == $this->getAttribute($column);
                        }
                    );
                    $option = array_shift($option);
                    try {
                        return $option->text;
                    } catch (\Throwable $th) {
                        return null;
                    }
                }
                if ($input->valueoriginselector == 'table') {
                    $info = __crudInfo($input->tabledata);
                    $subModel = $info['model'];
                    $item = $subModel::where($input->tablekeycolumn, $this->getAttribute($column))->first();
                    try {
                        if ( $type == 'value' ) {
                            return $item->{ $input->tabletextcolumn };
                        }
                        if ( $type == 'relation' ) {
                            return $item;
                        }
                    } catch (\Throwable $th) {
                        return null;
                    }
                }
                if ($input->valueoriginselector == 'model-nocrud') {
                    $subModel = $input->tabledata;
                    $item = $subModel::where($input->tablekeycolumn, $this->getAttribute($column))->first();
                    try {
                        if ( $type == 'value' ) {
                            return $item->{ $input->tabletextcolumn };
                        }
                        if ( $type == 'relation' ) {
                            return $item;
                        }
                    } catch (\Throwable $th) {
                        return null;
                    }
                }
            }
            if ($input->type == 'gallery') {
                return Gallery::with(['items'])->find($this->getAttribute($column))->items;
                return $this->belongsToMany(Multimedia::class, 'gallery_multimedia', 'gallery_id', 'multimedia_id');
            }
        }
    }

    public function getPkvAttribute() {
        if ($this->uuid) {
            return $this->uuid;
        }
        return $this->id;
    }
}
