<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Type;

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
            $content = json_decode(file_get_contents($file->getPathname()));
            if (Schema::hasTable($content->table->tablename)) {
                Schema::table($content->table->tablename, function (Blueprint $table) use ($content) {
                    $this->table($table, $content);
                });
            } else {
                Schema::create($content->table->tablename, function (Blueprint $table) use ($content) {
                    $this->table($table, $content);
                });
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
            $change = false;
            if (Schema::hasColumn($content->table->tablename, $input->columnname)) {
                $change = true;
            }
            if($input->type == 'text') {
                $col[] = $table->string($input->columnname);
            }
            if($input->type == 'color') {
                $col[] = $table->string($input->columnname);
            }
            if($input->type == 'email') {
                $col[] = $table->string($input->columnname);
            }
            if($input->type == 'textarea') {
                $col[] = $table->longText($input->columnname);
            }
            if($input->type == 'wysiwyg') {
                $col[] = $table->longText($input->columnname);
            }
            if($input->type == 'number') {
                $col[] = $table->double($input->columnname);
            }
            if($input->type == 'money') {
                $col[] = $table->double($input->columnname);
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
