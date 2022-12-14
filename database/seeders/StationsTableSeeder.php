<?php

namespace Database\Seeders;

use App\Models\Sacco;
use App\Models\Station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Sacco::all()->each(function (Sacco $sacco) {
            Station::factory()->count(10)->create(['sacco_id' => $sacco->id]);
        });
    }
}
