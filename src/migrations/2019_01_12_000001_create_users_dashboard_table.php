<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersDashboardTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        try {
            // Se inicia una transacción
            DB::beginTransaction();
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			// For error:
			// SQLSTATE[HY000]: General error: 1364 Field 'id' doesn't have a default value (SQL: insert into `migrations` (`migration`, `batch`) values (2019_01_12_000001_create_users_dashboard_table, 2))
			DB::statement('ALTER TABLE `migrations` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT');
			if (Schema::hasTable('users')) {
				$users = DB::table("users")->get();
				Schema::dropIfExists('users');
			}			
			Schema::create('users', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->uuid('uuid')->nullable();
				//
				$table->boolean('root')->default(0);
				$table->string('username')->unique();
				//
				$table->string('name');
				$table->string('email')->unique();
				$table->timestamp('email_verified_at')->nullable();
				$table->string('password');
				//
				$table->rememberToken();
				$table->timestamps();
				$table->softDeletes();
			});
			if (isset($users)) {
				foreach($users as $user) {
					DB::table('users')->insert(get_object_vars($user));
				}
			}
			DB::statement('SET FOREIGN_KEY_CHECKS=1');
            DB::commit();
        } catch (\Exception $e) {
            //
            // Si se encuentra algun error, se cancela la transacción
			DB::rollback();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0');
		Schema::dropIfExists('users');
		DB::statement('SET FOREIGN_KEY_CHECKS=1');
	}
}
