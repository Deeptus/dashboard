<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisplayOnlyRootToGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $groupsTable = config('acl.tables.groups', 'groups');
        Schema::table($groupsTable, function (Blueprint $table) {
            $table->boolean('display_only_root')->after('description')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $groupsTable = config('acl.tables.groups', 'groups');
        Schema::table($groupsTable, function (Blueprint $table) use ($groupsTable) {
            if (Schema::hasColumn($groupsTable, 'display_only_root')) {
                $table->dropColumn('display_only_root');
            }
        });
    }
}
