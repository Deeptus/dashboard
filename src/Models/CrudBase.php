<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Support\Str;

trait CrudBase
{
    public function __get($key)
    {
        if (Str::endsWith($key, '_rel_val')) {
            $column = str_replace('_rel_val', '', $key);
            if (!$this->getAttribute($column)) {
                return '';
            }
            // get info json
            $dirPath  = app_path('Dashboard');
            $filePath = $dirPath . '/' . 'victimas' . '.json';
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
