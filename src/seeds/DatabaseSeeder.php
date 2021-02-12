<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
      $this->call(PermissionsTableSeeder::class);
      //$this->call(RubrosTableSeeder::class);
      //$this->call(MonedasTableSeeder::class);
      $this->call(GroupsTableSeeder::class);
      $this->call(GroupHasPermissionsTableSeeder::class);
      $this->call(UserHasGroupsTableSeeder::class);
      //$this->call(SuperficiesTableSeeder::class);
        global $__seeders;
        $this->call($__seeders);
    }
}
