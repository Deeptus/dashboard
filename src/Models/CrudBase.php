<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Gallery;
use AporteWeb\Dashboard\Models\Multimedia;
use Illuminate\Support\Facades\Storage;

trait CrudBase {
    
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

                if ($input->valueoriginselector == 'values') {
                    $option = array_filter(
                        $input->options,
                        function ($e) use (&$column) {
                            return $e->key == $this->getAttribute($column);
                        }
                    );
                    $option = array_shift($option);
                    return $option->text;
                }
            }
        }
        return $this->getAttribute($key);
    }
}
