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
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'uuid')) {
                $table->dropColumn('uuid');
            }
        });
    }
    public function table($table, $content)
    {
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
        foreach ($content->inputs as $inputKey => $input) {
            $change = false;
            if (Schema::hasColumn($content->table->tablename, $input->columnname)) {
                $change = true;
            }    
            if($input->type == 'text') {
                $col = $table->string($input->columnname);
            }
            if($input->type == 'textarea') {
                $col = $table->longText($input->columnname);
            }
            if($input->type == 'number') {
                $col = $table->double($input->columnname);
                $change = false;
            }
            if($input->type == 'true_or_false') {
                $col = $table->boolean($input->columnname);
            }
            if($input->type == 'select') {
                $col = $table->unsignedBigInteger($input->columnname);
            }
            if($input->nullable == 1) {
                $col->nullable();
            }
            $col->change();
        }
        if (!Schema::hasColumn($content->table->tablename, 'created_at')) {
            $table->timestamps();
        }
        if (!Schema::hasColumn($content->table->tablename, 'deleted_at')) {
            $table->softDeletes();
        }
}
}
