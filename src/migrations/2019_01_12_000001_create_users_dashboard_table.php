<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateUsersDashboardTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        /* try { */
            // Se inicia una transacción
            // DB::beginTransaction();
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			// For error:
			// SQLSTATE[HY000]: General error: 1364 Field 'id' doesn't have a default value (SQL: insert into `migrations` (`migration`, `batch`) values (2019_01_12_000001_create_users_dashboard_table, 2))
			DB::statement('ALTER TABLE `migrations` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT');
			// dump(Schema::hasTable('users'));
			if (Schema::hasTable('users')) {
				$users = DB::table("users")->get();
				Schema::dropIfExists('users');
			}
            if (Schema::hasTable('users')) {
                Schema::table('users', function (Blueprint $table) {
                    $this->table($table);
                });
            } else {
                Schema::create('users', function (Blueprint $table) {
                    $this->table($table);
                });
            }
			// dump($users);
			if (isset($users)) {
				foreach($users as $user) {
					$user->uuid = __uuid();
					DB::table('users')->insert(get_object_vars($user));
				}
			}
			DB::statement('SET FOREIGN_KEY_CHECKS=1');
            // DB::commit();
        /*} catch (\Exception $e) {
			$output = new ConsoleOutput();
			$output->writeln("\033[01;31m$e\033[0m");
			throw new Exception($e);
            //
            // Si se encuentra algun error, se cancela la transacción
			// DB::rollback();
		}*/
	}
	public function table($table) {
		if (!Schema::hasColumn('users', 'id')) {
			$table->bigIncrements('id');
		}
		if (!Schema::hasColumn('users', 'uuid')) {
			$table->uuid('uuid')->nullable();
		}
		//
		if (!Schema::hasColumn('users', 'root')) {
			$table->boolean('root')->default(0);
		}
		if (!Schema::hasColumn('users', 'username')) {
			$table->string('username')->unique();
		}
		//
		if (!Schema::hasColumn('users', 'name')) {
			$table->string('name');
		}
		if (!Schema::hasColumn('users', 'email')) {
			$table->string('email')->unique();
		}
		if (!Schema::hasColumn('users', 'email_verified_at')) {
			$table->timestamp('email_verified_at')->nullable();
		}
		if (!Schema::hasColumn('users', 'password')) {
			$table->string('password');
		}
		//
		if (!Schema::hasColumn('users', 'remember_token')) {
			$table->rememberToken();
		}
		if (!Schema::hasColumn('users', 'created_at')) {
			$table->timestamps();
		}
		if (!Schema::hasColumn('users', 'deleted_at')) {
			$table->softDeletes();
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
