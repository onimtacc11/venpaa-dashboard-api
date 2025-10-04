<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\DocNumberSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LocationSeeder::class,
            AdminUserSeeder::class,
            DocNumberSeeder::class,
        ]);
    }
}