<?php

namespace Database\Seeders;

use App\Models\Station;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class VehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = User::whereHas('roles', function (Builder $query) {
            $query->where('id', 4);
        })->get();

        Station::all()->each(function (Station $station) use ($users) {
            Vehicle::factory()->count(10)->hasAttached($users->random(2))
                ->create(['station_id' => $station->id]);
        });
    }
}
