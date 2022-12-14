<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            PermissionsTableSeeder::class,
            UsersTableSeeder::class,
            StationsTableSeeder::class,
            VehiclesTableSeeder::class,
            ChargesTableSeeder::class
        ]);
    }
}
