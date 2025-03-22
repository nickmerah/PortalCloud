<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('permissions')->insert([
            ['feature' => 'accessSettings', 'group_id' => 1],
            ['feature' => 'accessUsers', 'group_id' => 1],
            ['feature' => 'accessBiodata', 'group_id' => 1],
            ['feature' => 'accessReports', 'group_id' => 1],
            ['feature' => 'accessReports', 'group_id' => 2],
            ['feature' => 'accessRegistrationReports', 'group_id' => 1],
            ['feature' => 'seeDashboard', 'group_id' => 1],
            ['feature' => 'seeDashboard', 'group_id' => 2],
        ]);
    }
}
