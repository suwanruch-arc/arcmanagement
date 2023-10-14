<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        // \App\Models\Partner::factory(2)->create();
        // \App\Models\Department::factory(2)->create();
        // DB::table('partners')->insert([
        //     [
        //         'name' => 'Arc Innovative',
        //         'keyword' => 'ARC',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'name' => 'UOBTMRW',
        //         'keyword' => 'UOB',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'name' => 'KBank',
        //         'keyword' => 'KBANK',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        // ]);

        // DB::table('departments')->insert([
        //     [
        //         'partner_id' => 1,
        //         'name' => 'IT',
        //         'keyword' => 'IT',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'partner_id' => 1,
        //         'name' => 'HR',
        //         'keyword' => 'HR',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'partner_id' => 2,
        //         'name' => 'UOB',
        //         'keyword' => 'UOB',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'partner_id' => 2,
        //         'name' => 'TMRW',
        //         'keyword' => 'TMRW',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'partner_id' => 2,
        //         'name' => 'Debit',
        //         'keyword' => 'DB',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'partner_id' => 2,
        //         'name' => 'Credit',
        //         'keyword' => 'CD',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        // ]);
        // DB::table('users')->insert([
        //     'name' => $faker->name(),
        //     'email' => $faker->email(),
        //     'contact_number' => $faker->phoneNumber(),
        //     'username' => 'admin',
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        //     'partner_id' => 1,
        //     'department_id' => 1,
        // ]);
        // \App\Models\User::factory(10)->create();
        $faker = \Faker\Factory::create();
        DB::table('users')->insert([[
            'name' => 'Suwanruch Singhasanee',
            'email' => 'suwanruchs@arcinnovative.com',
            'contact_number' => '0867751404',
            'username' => 'suwanruchs',
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ], [
            'name' => 'Jirayu Chantatawiwong',
            'email' => 'jirayuc@arcinnovative.com',
            'contact_number' => '0867751404',
            'username' => 'jirayu',
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ], [
            'name' => 'Thitirat Sirichetpong',
            'email' => 'thitirats@arcinnovative.com',
            'contact_number' => '0924405695',
            'username' => 'thitirats',
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ], [
            'name' => 'Thanawan Khonkum',
            'email' => 'thanawank@arcinnovative.com',
            'contact_number' => '0867751404',
            'username' => 'thanawank',
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ]]);
    }
}
