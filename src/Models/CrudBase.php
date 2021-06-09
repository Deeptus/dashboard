<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Gallery;
use AporteWeb\Dashboard\Models\Multimedia;
use Illuminate\Support\Facades\Storage;

trait CrudBase {

    public $listEnableMethods = [];

    public function __construct() {

        $dirPath  = app_path('Dashboard');
        $filePath = $dirPath . '/' . $this->table . '.json';

        if (file_exists($filePath)) {
            $content = json_decode(file_get_contents($filePath));
            $table   = $content->table;
            foreach ($content->inputs as $key => $input) {
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
                return $this->firstWhere('uuid', $args[0]) ?? abort(404);
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
                if ($input && $input->type == 'subForm') {
                    $className = str_replace(['_', '-', '.'], ' ', $input->tabledata);
                    $className = ucwords($className);
                    $className = str_replace(' ', '', $className);
                    $subModel = "\\App\\Models\\" . $className;
                    return $subModel::where($input->tablekeycolumn, $this->id)->get();
                }
                if ($input && $input->type == 'multimedia_file') {
                    $file = Multimedia::find($this->{$input->columnname . '_id'});
                    if ($file) {
                        return [
                            'url'  => asset(Storage::url($file->path)),
                            'path' => $file->path,
                            'id'   => $file->id,
                            'type' => Storage::mimeType($file->path)
                        ];
                    }
                }
                if ($input && $input->type == 'gallery') {
                    $file = Multimedia::find($this->{$input->columnname . '_id'});
                    if ($file) {
                        return [
                            'url'  => asset(Storage::url($file->path)),
                            'path' => $file->path,
                            'id'   => $file->id,
                            'type' => Storage::mimeType($file->path)
                        ];
                    }
                }
            }
        }

        if (Str::endsWith($key, '_rel_val')) {
            $column = str_replace('_rel_val', '', $key);
            if (!$this->getAttribute($column)) {
                return '';
            }
            // get info json
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
                if ($input->type == 'select') {
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
                        
                        $className = str_replace(['_', '-', '.'], ' ', $input->tabledata);
                        $className = ucwords($className);
                        $className = str_replace(' ', '', $className);
                        $subModel = "\\App\\Models\\" . $className;
                        $item = $subModel::where($input->tablekeycolumn, $this->getAttribute($column))->first();
                        try {
                            return $item->{ $input->tabletextcolumn };
                        } catch (\Throwable $th) {
                            return null;
                        }
                    }
                }
                if ($input->type == 'gallery') {
                    $column = str_replace('_rel_val', '', $key);
                    return Gallery::with(['items'])->find($this->getAttribute($column))->items;
                    return $this->belongsToMany(Multimedia::class, 'gallery_multimedia', 'gallery_id', 'multimedia_id');
                }
            }
        }
        return $this->getAttribute($key);
    }
    public function getPkvAttribute() {
        if ($this->uuid) {
            return $this->uuid;
        }
        return $this->id;
    }
}
