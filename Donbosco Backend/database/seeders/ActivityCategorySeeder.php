<?php

namespace Database\Seeders;

use App\Models\ActivityCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $categories = [
            [
                'name' => ['en' => 'Catechism', 'ar' => 'التعليم المسيحي'],
                'slug' => Str::slug('Catechism'),
                'description' => [
                    'en' => 'Weekly Christian formation, biblical education, and spiritual growth for children and teens.',
                    'ar' => 'التنشئة المسيحية الأسبوعية، التثقيف الإنجيلي، والنمو الروحي للأطفال واليافعين.'
                ],
            ],
            [
                'name' => ['en' => 'Scouts', 'ar' => 'الكشافة'],
                'slug' => Str::slug('Scouts'),
                'description' => [
                    'en' => 'Don Bosco Scout Group activities, outdoor skills, leadership, and community service projects.',
                    'ar' => 'أنشطة فوج كشافة دون بوسكو، مهارات حياة الخلاء، القيادة، ومشاريع الخدمة المجتمعية.'
                ],
            ],
            [
                'name' => ['en' => 'University Youth', 'ar' => 'الشبيبة الجامعية'],
                'slug' => Str::slug('University Youth'),
                'description' => [
                    'en' => 'Spiritual retreats, intellectual debates, and social gatherings tailored for university students.',
                    'ar' => 'الرياضات الروحية، الحوارات الفكرية، واللقاءات الاجتماعية المخصصة لطلاب الجامعة.'
                ],
            ],
            [
                'name' => ['en' => 'Educational Courses', 'ar' => 'الدورات التعليمية'],
                'slug' => Str::slug('Educational Courses'),
                'description' => [
                    'en' => 'Professional development workshops, computer labs, language courses, and career orientation.',
                    'ar' => 'ورشات التطوير المهني، مختبرات الحاسوب، لغات أجنبية، والتوجيه المهني.'
                ],
            ],
            [
                'name' => ['en' => 'Sports & Recreation', 'ar' => 'الرياضة والترفيه'],
                'slug' => Str::slug('Sports and Recreation'),
                'description' => [
                    'en' => 'Football tournaments, basketball leagues, and general physical and fun activities inside the playground.',
                    'ar' => 'دوريات كرة القدم، بطولات كرة السلة، والأنشطة البدنية والترفيهية العامة داخل الملاعب.'
                ],
            ],
            [
                'name' => ['ar' => 'رياضية', 'en' => 'Sports'],
                'slug' => 'sports',
                'description' => ['ar' => 'أنشطة رياضية وبدنية', 'en' => 'Physical and sports activities'],
            ],
            [
                'name' => ['ar' => 'ثقافية', 'en' => 'Cultural'],
                'slug' => 'cultural',
                'description' => ['ar' => 'أنشطة ثقافية وتعليمية', 'en' => 'Cultural and educational activities'],
            ],
        ];

        foreach ($categories as $category) {
            ActivityCategory::create($category);
        }
    }
}
