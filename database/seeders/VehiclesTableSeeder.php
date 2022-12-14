<?php

namespace Database\Seeders;

use App\Models\Station;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Station::all()->each(function (Station $station) {
            Vehicle::factory()->count(10)->create(['station_id' => $station->id]);
        });
    }
}
