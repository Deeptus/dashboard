<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;

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
            Schema::create($content->table->tablename, function (Blueprint $table) use ($content) {
                $table->bigIncrements('id');
                $table->uuid('uuid');
                foreach ($content->inputs as $inputKey => $input) {
                    if (!Schema::hasColumn($content->table->tablename, $input->columnname)) {
                        if($input->type == 'text') {
                            $col = $table->string($input->columnname);
                        }
                        if($input->type == 'textarea') {
                            $col = $table->longText($input->columnname);
                        }
                        if($input->type == 'number') {
                            $col = $table->double($input->columnname);
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

                    }
                }
                $table->timestamps();
                $table->softDeletes();
            });
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
}
