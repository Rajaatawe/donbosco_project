<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => [
                    'ar' => 'أعطني النفوس وخذ الباقي..',
                    'en' => 'Give me souls, take away the rest..'
                ],
                'subtitle' => [
                    'ar' => 'مركز القديس يوحنا بوسكو – جرمانا، منارة رجاء للشباب السوري',
                    'en' => 'Don Bosco Center – Jaramana, a beacon of hope for Syrian youth'
                ],
                'image' => 'banners/hero.png',
                'button_text' => [
                    'ar' => 'تعرف علينا أكثر',
                    'en' => 'Learn More About Us'
                ],
                'button_url' => '/about-us',
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'title' => [
                    'ar' => 'طور مهاراتك المهنية والتقنية',
                    'en' => 'Develop Your Vocational and Technical Skills'
                ],
                'subtitle' => [
                    'ar' => 'أكثر من 1500 خريج لسوق العمل.. انضم الآن لكورساتنا المتنوعة',
                    'en' => 'Over 1500 graduates in the labor market.. Join our diverse courses now'
                ],
                'image' => 'banners/tvet_section.png',
                'button_text' => [
                    'ar' => 'انضم لمجتمعنا على واتساب',
                    'en' => 'Join Our WhatsApp Community'
                ],
                'button_url' => 'https://chat.whatsapp.com/BG2sBQlaZdaJRzon64WdcQ',
                'sort_order' => 2,
                'status' => 'active',
            ],
            [
                'title' => [
                    'ar' => 'إبداع بلا حدود',
                    'en' => 'Creativity Without Limits'
                ],
                'subtitle' => [
                    'ar' => 'نفخر بتخريج ودعم ذوي الاحتياجات الخاصة في ورشات صناعة الشموع اليدوية',
                    'en' => 'We take pride in graduating and supporting people with special needs in handmade candle workshops'
                ],
                'image' => 'banners/special_needs.jpeg',
                'button_text' => [
                    'ar' => 'تصفح أعمالنا',
                    'en' => 'Browse Our Work'
                ],
                'button_url' => '/gallery',
                'sort_order' => 3,
                'status' => 'active',
            ],
        ];

        foreach ($banners as $bannerData) {
            Banner::create($bannerData);
        }
    }
}
