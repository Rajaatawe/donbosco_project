<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        User::truncate();

        Schema::enableForeignKeyConstraints();


        $anotherAdmin = User::query()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'role' => 1,
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $anotherAdmin->assignRole('admin');


        $contentUser = User::query()->create([
            'name' => 'content',
            'email' => 'content@gmail.com',
            'password' => bcrypt('123'),
            'role' => 2,
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $contentUser->assignRole('content');


        $receptionUser = User::query()->create([
            'name' => 'reception',
            'email' => 'reception@gmail.com',
            'password' => bcrypt('123'),
            'role' => 3,
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $receptionUser->assignRole('reception');


        // المستخدم العادي الجديد للتجربة (Role 4)
        // User::query()->create([
        //     'name' => 'normal user',
        //     'email' => 'user@gmail.com',
        //     'password' => bcrypt('123'),
        //     'role' => 4,
        //     'email_verified_at' => now(),
        //     'status' => 1, // نشط تلقائياً
        // ]);
    }
}
