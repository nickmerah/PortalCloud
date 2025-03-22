<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Top-level menus
        $dashboard = DB::table('menus')->insertGetId([
            'name' => 'Dashboard',
            'url' => '/welcome',
            'icon' => 'monitor',
            'parent_id' => null,
            'order' => 1,
        ]);

        $settings = DB::table('menus')->insertGetId([
            'name' => 'Settings',
            'url' => null,
            'icon' => 'settings',
            'parent_id' => null,
            'order' => 2,
        ]);

        // Submenus for Settings
        DB::table('menus')->insert([
            ['name' => 'Institution Info', 'url' => '/schoolinfo', 'parent_id' => $settings, 'order' => 1],
            ['name' => 'School', 'url' => '/faculties', 'parent_id' => $settings, 'order' => 2],
            ['name' => 'Department', 'url' => '/depts', 'parent_id' => $settings, 'order' => 3],
            ['name' => 'Programme', 'url' => '/programmes', 'parent_id' => $settings, 'order' => 4],
            ['name' => 'Programme Type', 'url' => '/programmetypes', 'parent_id' => $settings, 'order' => 5],
            ['name' => 'Course of Study', 'url' => '/cos', 'parent_id' => $settings, 'order' => 6],
            ['name' => 'Level', 'url' => '/levels', 'parent_id' => $settings, 'order' => 7],
        ]);

        // Fees Section
        $fees = DB::table('menus')->insertGetId([
            'name' => 'Fees',
            'url' => null,
            'icon' => 'dollar-sign',
            'parent_id' => null,
            'order' => 3,
        ]);

        DB::table('menus')->insert([
            ['name' => 'Applicant Fee', 'url' => '/appfees', 'parent_id' => $fees, 'order' => 1],
            ['name' => 'Clearance Pack/Fees', 'url' => '/packs', 'parent_id' => $fees, 'order' => 2],
        ]);

        // Session Section
        DB::table('menus')->insert([
            ['name' => 'Session', 'url' => '/session', 'parent_id' => $settings, 'order' => 8],
        ]);

        // Portal Section
        DB::table('menus')->insert([
            ['name' => 'Open/Close Portal', 'url' => '/portal', 'parent_id' => $settings, 'order' => 9],
        ]);

        // Users Section
        $users = DB::table('menus')->insertGetId([
            'name' => 'Users',
            'url' => null,
            'icon' => 'user-check',
            'parent_id' => null,
            'order' => 4,
        ]);

        DB::table('menus')->insert([
            ['name' => 'Users Management', 'url' => '/users', 'parent_id' => $users, 'order' => 1],
        ]);

        // Biodata Section
        $biodata = DB::table('menus')->insertGetId([
            'name' => 'Biodata',
            'url' => null,
            'icon' => 'users',
            'parent_id' => null,
            'order' => 5,
        ]);

        DB::table('menus')->insert([
            ['name' => 'View/Edit Applicants', 'url' => '/applicants', 'parent_id' => $biodata, 'order' => 1],
            ['name' => 'Get Applicant Password', 'url' => '/applicantspwd', 'parent_id' => $biodata, 'order' => 2],
            ['name' => 'O-Level Subjects', 'url' => '/olevelsubjects', 'parent_id' => $biodata, 'order' => 3],
        ]);

        // Reports Section
        $reports = DB::table('menus')->insertGetId([
            'name' => 'Reports',
            'url' => null,
            'icon' => 'server',
            'parent_id' => null,
            'order' => 6,
        ]);

        DB::table('menus')->insert([
            ['name' => 'Applicant Payment', 'url' => '/appfeepayment', 'parent_id' => $reports, 'order' => 1],
            ['name' => 'Applicant Registration', 'url' => '/appreg', 'parent_id' => $reports, 'order' => 2],
            ['name' => 'Clearance Payment', 'url' => '/clearpayment', 'parent_id' => $reports, 'order' => 3],
        ]);

        // Logout Section
        DB::table('menus')->insert([
            'name' => 'Logout',
            'url' => '/logout',
            'icon' => 'log-out',
            'parent_id' => null,
            'order' => 7,
        ]);
    }
}
