<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class AddUuidToGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'uuid')) {
                $table->uuid('uuid')->after('id');
            }
        });

        Schema::table('groups', function (Blueprint $table) {
            if (!Schema::hasColumn('display_only_root', 'boolean')) {
                $table->boolean('display_only_root')->after('id');
            }
        });


        /*$all = User::withTrashed()->get();
        foreach ($all as $key => $item) {
            $item->uuid = __uuid();
            $item->save();
        }*/
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
