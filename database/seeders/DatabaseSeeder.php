<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Suwanruch Singhasanee',
                'email' => 'suwanruchs@arcinnovative.com',
                'contact_number' => '0926261359',
                'username' => 'suwanruchs',
                'password' => Hash::make('password'), // password
                'remember_token' => Str::random(10),
                'position' => 'admin',
                'role' => 'admin'
            ]
        ]);

        $partners = Partner::factory()->count(5)->create();

        // Create 10 departments and associate them with the partners
        $departments = collect();
        foreach ($partners as $partner) {
            $departments = $departments->merge(
                Department::factory()->count(2)->create(['partner_id' => $partner->id])
            );
        }

        // Create 49 users and associate them with the departments and partners
        User::factory()->count(49)->create()->each(function ($user) use ($departments) {
            $department = $departments->random();
            $user->department_id = $department->id;
            $user->partner_id = $department->partner_id;
            $user->save();
        });
    }
}
