<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('partners')->insert([
            [
                'name' => 'Arc Innovative',
                'keyword' => 'arc',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'UOBTMRW',
                'keyword' => 'uob',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'KBank',
                'keyword' => 'kbank',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        DB::table('departments')->insert([
            [
                'partner_id' => 1,
                'name' => 'IT',
                'keyword' => 'it',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'partner_id' => 1,
                'name' => 'HR',
                'keyword' => 'hr',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'partner_id' => 2,
                'name' => 'UOB',
                'keyword' => 'uob',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'partner_id' => 2,
                'name' => 'TMRW',
                'keyword' => 'tmrw',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'partner_id' => 2,
                'name' => 'Debit',
                'keyword' => 'db',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'partner_id' => 2,
                'name' => 'Credit',
                'keyword' => 'cd',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
        \App\Models\User::factory(10)->create();
    }
}
