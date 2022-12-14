<?php

namespace Database\Seeders;

use App\Models\Charge;
use App\Models\Sacco;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChargesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Sacco::all()->each(function (Sacco $sacco) {
            Charge::factory()->count(10)->create(['sacco_id' => $sacco->id]);
        });
    }
}
