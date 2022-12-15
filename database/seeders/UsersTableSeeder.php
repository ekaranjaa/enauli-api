<?php

namespace Database\Seeders;

use App\Models\Sacco;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roles = Role::whereNotIn('id', [1, 2])->get();

        $sysAdmin = User::factory()->create([
            'name' => 'Sacco Admin',
            'email' => 'admin@example.com',
            'phone_number' => '0712345678'
        ])->assignRole('System Admin');

        $saccoOwner = User::factory()->create([
            'name' => 'Sacco Owner',
            'email' => 'owner@example.com',
            'phone_number' => '0787654321'
        ])->assignRole('Owner');

        $saccos = Sacco::factory()->count(10)->create(['owner_id' => $saccoOwner->id]);

        $saccos->each(function (Sacco $sacco) use ($roles, $saccoOwner) {
            User::factory()->count(10)->create()->each(function (User $user) use ($sacco, $roles) {
                $randomRole = $roles->random();
                $user->assignRole($randomRole->name);
                $user->saccos()->attach($sacco, ['role_id' => $randomRole->id]);
            });

            $saccoOwner->saccos()->attach($sacco, ['role_id' => 2]);
        });
    }
}
