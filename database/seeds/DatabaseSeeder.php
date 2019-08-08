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
        $this->call(RolesAndPermissionsTableSeeder::class);
        $this->command->info('Seeded the roles and permissions!');
        $this->call(UsersTableSeeder::class);
        $this->command->info('Seeded the users!');
    }
}
