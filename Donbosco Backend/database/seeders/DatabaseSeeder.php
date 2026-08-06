<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
                 $this->call(PermissionSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(RolesSeeder::class);
        //  $this->call(ContactMessageSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(SiteSettingSeeder::class);
        $this->call(ActivityCategorySeeder::class);
        // $this->call(ActivitySeeder::class);
        // $this->call(NewsSeeder::class);
        // $this->call(EventSeeder::class);
        // $this->call(ProgramSeeder::class);
        // $this->call(GalleryAlbumSeeder::class);
        // $this->call(GalleryImageSeeder::class);
    }
}
