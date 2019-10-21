<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'username' => 'admin',
            'email' => 'admin@local.test',
            'password' => bcrypt('admin'),
            'root' => 1,
        ]);
    }
}
