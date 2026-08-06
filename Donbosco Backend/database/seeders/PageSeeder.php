<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            // 1. صفحة من نحن
            [
                'title' => [
                    'ar' => 'من نحن - القديس يوحنا بوسكو',
                    'en' => 'About Us - Saint John Bosco'
                ],
                'slug' => 'about-us',
                'content' => [
                    'ar' => 'ولد القديس يوحنا بوسكو عام 1815 في إيطاليا. أسس "جمعية السالزيان" عام 1859 لرعاية الشباب. اليوم، تنتشر هذه العائلة التربوية في أكثر من 134 بلداً حول العالم، وتحديداً في الشرق الأوسط (سوريا، لبنان، مصر، والأراضي المقدسة)، متبعة "النظام الوقائي" في التربية الذي يدمج العقل والدين والمحبة.',
                    'en' => 'Saint John Bosco was born in 1815 in Italy. He founded the "Salesian Society" in 1859 to care for youth. Today, this educational family is present in over 134 countries worldwide, specifically in the Middle East (Syria, Lebanon, Egypt, and the Holy Land), following the "Preventive System" in education that integrates reason, religion, and loving-kindness.'
                ],
                'status' => 'published',
            ],

            // 2. الرؤية والرسالة
            [
                'title' => [
                    'ar' => 'الرؤية والرسالة',
                    'en' => 'Vision and Mission'
                ],
                'slug' => 'vision-mission',
                'content' => [
                    'ar' => 'رؤيتنا هي بناء بيئة آمنة ومحفزة تُمكن الشباب السوري من تنمية قدراتهم واكتشاف رسالتهم في الحياة. نهدف إلى تمكين الشباب من خلال تزويدهم بالمهارات المهنية الحديثة وتنمية القيم الإنسانية والروحية لديهم ليصبحوا مواطنين صالحين يخدمون مجتمعهم.',
                    'en' => 'Our vision is to build a safe and stimulating environment that enables Syrian youth to develop their capabilities and discover their mission in life. We aim to empower youth by providing them with modern vocational skills and developing their human and spiritual values to become good citizens serving their community.'
                ],
                'status' => 'published',
            ],

            // 3. أقسام المركز
            [
                'title' => [
                    'ar' => 'أقسام مركز دون بوسكو جرمانا',
                    'en' => 'Don Bosco Jaramana Departments'
                ],
                'slug' => 'our-departments',
                'content' => [
                    'ar' => 'يتوزع العمل في مركزنا لخدمة الشباب في ثلاثة مستويات: <br> 1. **الطابق الأرضي**: منطقة الدراسة (Study Zone) لتوفير جو هادئ للطلاب. <br> 2. **الطابق الأول**: قسم الدعم التعليمي (After School) من الصف الرابع وحتى البكالوريا. <br> 3. **القبو**: قسم TVET للتعليم والتدريب المهني والتقني، والذي يضم ورشة الخياطة المتخصصة.',
                    'en' => 'Our center serves youth across three levels: <br> 1. **Ground Floor**: Study Zone providing a quiet atmosphere for students. <br> 2. **First Floor**: After School educational support from 4th grade to Baccalaureate. <br> 3. **Basement**: TVET Department for vocational and technical training, including a specialized sewing workshop.'
                ],
                'status' => 'published',
            ],

            // 4. التدريب المهني والتقني TVET
            [
                'title' => [
                    'ar' => 'التعليم والتدريب المهني والتقني (TVET)',
                    'en' => 'Technical and Vocational Education and Training (TVET)'
                ],
                'slug' => 'tvet-programs',
                'content' => [
                    'ar' => 'يعد قسم TVET ركيزة أساسية في مركزنا، حيث خرجنا ما يقارب 1500 شخص. نقدم كورسات ثابتة تشمل (التمديدات الكهربائية المنزلية، الخياطة، الطاقة الشمسية، الفوتوغراف والفيديوغراف)، بالإضافة إلى دورات متغيرة حسب سوق العمل مثل (التكييف والتبريد، والدهان). كما نولي اهتماماً خاصاً بذوي الاحتياجات الخاصة عبر ورشات صناعة الشموع، ونسعى دائماً لربط خريجينا بسوق العمل مباشرة.',
                    'en' => 'The TVET department is a cornerstone of our center, having graduated approximately 1,500 individuals. We offer permanent courses including (Home Electrical Wiring, Sewing, Solar Energy, Photography, and Videography), alongside labor market-driven courses such as (AC & Refrigeration, Painting). We also give special attention to people with special needs through candle-making workshops, always striving to link our graduates directly to the labor market.'
                ],
                'status' => 'published',
            ],
        ];

        foreach ($pages as $pageData) {
            Page::create($pageData);
        }
    }
}
