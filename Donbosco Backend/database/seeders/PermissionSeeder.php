<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // News
            'view news',
            'create news',
            'edit news',
            'delete news',

            // Activities
            'view activities',
            'create activities',
            'edit activities',
            'delete activities',

            // Events
            'view events',
            'create events',
            'edit events',
            'delete events',

            // Pages
            'view pages',
            'create pages',
            'edit pages',
            'delete pages',

            // Albums
            'view albums',
            'create albums',
            'edit albums',
            'delete albums',

            // Programs (NEW)
            'view programs',
            'create programs',
            'edit programs',
            'delete programs',

            // Site Settings (NEW)
            'view site settings',
            'create site settings',
            'edit site settings',
            'delete site settings',

            // Images
            'upload images',

            // Contact Messages
            'read visitor messages',
            'change message status',
            'write internal notes',
            'mark message replied',

            // Admin
            'manage users',
            'manage permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $admin = Role::firstOrCreate([
            'name' => 'admin'
        ]);

        $content = Role::firstOrCreate([
            'name' => 'content'
        ]);

        $reception = Role::firstOrCreate([
            'name' => 'reception'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin Permissions
        |--------------------------------------------------------------------------
        */

        $admin->syncPermissions(Permission::all());

        /*
        |--------------------------------------------------------------------------
        | Content Permissions
        |--------------------------------------------------------------------------
        */

        $content->syncPermissions([

            // News
            'view news',
            'create news',
            'edit news',
            'delete news',

            // Activities
            'view activities',
            'create activities',
            'edit activities',
            'delete activities',

            // Events
            'view events',
            'create events',
            'edit events',
            'delete events',

            // Pages
            'view pages',
            'create pages',
            'edit pages',
            'delete pages',

            // Albums
            'view albums',
            'create albums',
            'edit albums',
            'delete albums',

            // // Programs
            // 'view programs',
            // 'create programs',
            // 'edit programs',

            
            // 'delete programs',

            // Site Settings (اختياري للموظف)
            // 'view site settings',
            // 'edit site settings',

            // Images
            'upload images',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Reception Permissions
        |--------------------------------------------------------------------------
        */

        $reception->syncPermissions([
            'read visitor messages',
            'change message status',
            'write internal notes',
            'mark message replied',
        ]);
    }
}
