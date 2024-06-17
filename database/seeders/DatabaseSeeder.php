<?php

namespace Database\Seeders;

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
            ]
        ]);
        \App\Models\User::factory(1000)->create();
    }
}
