<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class GenerateCrudTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $dirPath = __crudFolder();
        $files = File::allFiles($dirPath);
        foreach ($files as $fileKey => $file) {
            if ( $file->getExtension() != 'json' ) {
                continue;
            }
            $content = json_decode(file_get_contents($file->getPathname()));
            try {
                if (Schema::hasTable($content->table->tablename)) {
                    Schema::table($content->table->tablename, function (Blueprint $table) use ($content) {
                        $data = DB::select('SHOW INDEX FROM '.$content->table->tablename);
                        foreach ($data as $key) {
                            if ($key->Key_name == 'PRIMARY' && $key->Column_name != 'id') {
                                DB::statement("ALTER TABLE ".$content->table->tablename." DROP PRIMARY KEY");
                                /*$table->unique($key->Column_name);*/
                            }
                        }        
                        $this->table($table, $content);
                    });
                } else {
                    Schema::create($content->table->tablename, function (Blueprint $table) use ($content) {
                        $this->table($table, $content);
                    });
                }
            } catch (\Throwable $th) {
                abort(500, $content->table->tablename. ' - ' . $th->getMessage());
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    }

    public function table($table, $content) {
        // added support double to change

        if (!Type::hasType('double')) {
            Type::addType('double', FloatType::class);
        }
        
        if (!Schema::hasColumn($content->table->tablename, 'id')) {
            $table->bigIncrements('id');
        }
        if (!Schema::hasColumn($content->table->tablename, 'uuid')) {
            $table->uuid('uuid');
        }
        if (!Schema::hasColumn($content->table->tablename, 'slug')) {
            $table->string('slug')->nullable();
        }
        try {
            if ($content->table->is_authenticatable) {
                if (!Schema::hasColumn($content->table->tablename, 'email_verified_at')) {
                    $table->timestamp('email_verified_at')->nullable();
                }
                if (!Schema::hasColumn($content->table->tablename, 'password')) {
                    $table->string('password');
                }
                if (!Schema::hasColumn($content->table->tablename, 'remember_token')) {
                    $table->rememberToken();
                }
            }
        } catch (\Throwable $th) {
            $outputStyle = new OutputFormatterStyle('white', 'red', ['bold', 'blink']);
            $output = new ConsoleOutput();
            $output->getFormatter()->setStyle('error', $outputStyle);
            $output->writeln('<error>' . $content->table->tablename . ' is_authenticatable undefined</>');
        }
        try {
            if ($content->table->order_index) {
                if (!Schema::hasColumn($content->table->tablename, 'order_index')) {
                    $table->bigInteger('order_index')->default(0);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        foreach ($content->inputs as $inputKey => $input) {
            // saltar inputs que no son campos realmente
            $col = [];
            if($input->type == 'card-header') {
                continue;
            }
            if($input->type == 'subForm') {
                $subFolderPath = __crudFolder() . '/' . $input->tabledata . '.json';
                $subFolder = json_decode(file_get_contents($subFolderPath));
                if ( $subFolder->table->order_index != 1 ) {
                    $subFolder->table->order_index = 1;
                }
                // search for subform inputs
                $i = array_filter($subFolder->inputs, function($item) use ($input) {
                    return $item->columnname == $input->tablekeycolumn;
                });
                if (count($i) == 0) {
                    $subFolder->inputs[] = [
                        "columnname" => $input->tablekeycolumn,
                        "type" => "bigInteger",
                        "label" => new \stdClass(),
                        "unique" => 0,
                        "precision" => 0,
                        "scale" => 0,
                        "default" => "",
                        "nullable" => 1,
                        "validate" => 0,
                        "max" => "",
                        "min" => "",
                        "tabledata" => "",
                        "tablekeycolumn" => "",
                        "tabletextcolumn" => "",
                        "settable" => "3",
                        "listable" => 0,
                        "translatable" => 0
                    ];
                }
                file_put_contents($subFolderPath, json_encode($subFolder, JSON_PRETTY_PRINT));
            }
            $change = false;
            if (Schema::hasColumn($content->table->tablename, $input->columnname)) {
                $change = true;
            }
            if($input->type == 'text') {
                if ( @$input->translatable == 1 ) {
                    $col[] = $table->json($input->columnname);
                } else {
                    $col[] = $table->string($input->columnname);
                }
            }
            if($input->type == 'color') {
                $col[] = $table->string($input->columnname);
            }
            if($input->type == 'email') {
                $col[] = $table->string($input->columnname);
            }
            if($input->type == 'textarea') {
                if ( @$input->translatable == 1 ) {
                    $col[] = $table->json($input->columnname);
                } else {
                    $col[] = $table->longText($input->columnname);
                }
            }
            if($input->type == 'wysiwyg') {
                if ( @$input->translatable == 1 ) {
                    $col[] = $table->json($input->columnname);
                } else {
                    $col[] = $table->longText($input->columnname);
                }
            }
            if($input->type == 'number') {
                $col[] = $table->double($input->columnname);
            }
            if($input->type == 'decimal') {
                $col[] = $table->decimal($input->columnname, $input->precision, $input->scale);
            }
            if($input->type == 'money') {
                $col[] = $table->double($input->columnname);
            }
            if($input->type == 'checkbox') {
                $pivot_name = $content->table->tablename.'_'.$input->tabledata.'_'.$input->columnname;
                $cols = [
                    $content->table->tablename.'_id',
                    $input->tabledata.'_id'
                ];
                if (Schema::hasTable($pivot_name)) {
                    Schema::table($pivot_name, function (Blueprint $table) use ($content, $input, $cols, $pivot_name) {
                        foreach ($cols as $col) {
                            if ( !Schema::hasColumn($pivot_name, $col) ) {
                                $table->bigInteger($col);
                            }
                        }
                    });
                } else {
                    Schema::create($pivot_name, function (Blueprint $table) use ($content, $input, $cols) {
                        foreach ($cols as $col) {
                            $table->bigInteger($col);
                        }
                    });
                }
            }
            if($input->type == 'date') {
                $col[] = $table->date($input->columnname);
            }
            if($input->type == 'bigInteger') {
                $col[] = $table->bigInteger($input->columnname);
            }
            if($input->type == 'datetime') {
                $col[] = $table->dateTime($input->columnname);
            }
            if($input->type == 'true_or_false') {
                $col[] = $table->boolean($input->columnname);
            }
            if($input->type == 'select') {
                $col[] = $table->unsignedBigInteger($input->columnname);
            }
            if($input->type == 'select_string') {
                $col[] = $table->string($input->columnname);
            }
            if($input->type == 'multimedia_file') {
                if (Schema::hasColumn($content->table->tablename, $input->columnname)) {
                    $change = false;
                }    
                if (Schema::hasColumn($content->table->tablename, $input->columnname . '_id')) {
                    $change = true;
                }
                $col[] = $table->unsignedBigInteger($input->columnname . '_id');
            }
            if($input->type == 'gallery') {
                $col[] = $table->unsignedBigInteger($input->columnname);
            }
            if($input->type == 'map-select-lat-lng') {
                // deber ser
                // $col[] = $table->point($input->columnname);
                // mientras
                if (Schema::hasColumn($content->table->tablename, $input->columnname . '_lat') || Schema::hasColumn($content->table->tablename, $input->columnname . '_lng')) {
                    $change = true;
                }
                $col[] = $table->string($input->columnname . '_lat');
                $col[] = $table->string($input->columnname . '_lng');
            }

            foreach ($col as $key => $colItem) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $doctrineTable = $sm->listTableDetails($content->table->tablename);
                $indexName = $content->table->tablename.'_'.$input->columnname.'_unique';
                if($input->unique == 1) {
                    if ( !$doctrineTable->hasIndex($indexName) ) {
                        $colItem->unique();
                    }
                } else {
                    if ( $doctrineTable->hasIndex($indexName) ) {
                        $table->dropUnique($indexName);
                    }
                }
                if($input->nullable == 1) {
                    $colItem->nullable(true);
                } else {
                    $colItem->nullable(false);
                }
                if($input->default != '') {
                    $colItem->default($input->default);
                }
                if ($change) {
                    $colItem->change();
                }
            }
        }
        if (!Schema::hasColumn($content->table->tablename, 'created_at')) {
            $table->timestamps();
        }
        if (!Schema::hasColumn($content->table->tablename, 'deleted_at')) {
            $table->softDeletes();
        }
    }
}
