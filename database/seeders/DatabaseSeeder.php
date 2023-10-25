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
