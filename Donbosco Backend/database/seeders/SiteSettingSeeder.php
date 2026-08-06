<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [

            /*
            |----------------------------------------------------
            | GENERAL SETTINGS
            |----------------------------------------------------
            */

            [
                'key' => 'site_name',
                'value' => [
                    'ar' => 'مركز دون بوسكو - جرمانا',
                    'en' => 'Don Bosco Center - Jaramana'
                ],
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'site_slogan',
                'value' => [
                    'ar' => 'أعطني النفوس وخذ الباقي..',
                    'en' => 'Give me souls, take away the rest..'
                ],
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'main_logo',
                'value' => 'private/settings/logo.png',
                'type' => 'image',
                'group' => 'general',
            ],

            /*
            |----------------------------------------------------
            | SOCIAL MEDIA
            |----------------------------------------------------
            */

            [
                'key' => 'facebook_url',
                'value' => 'https://www.facebook.com/Don.Bocso.Damascus.Jaramana/',
                'type' => 'url',
                'group' => 'social_media',
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://www.instagram.com/donboscojaramana/',
                'type' => 'url',
                'group' => 'social_media',
            ],
            [
                'key' => 'whatsapp_community',
                'value' => 'https://chat.whatsapp.com/BG2sBQlaZdaJRzon64WdcQ',
                'type' => 'url',
                'group' => 'social_media',
            ],

            /*
            |----------------------------------------------------
            | CONTACT INFO
            |----------------------------------------------------
            */

            [
                'key' => 'tvet_phone',
                'value' => '+963 995 253 197',
                'type' => 'text',
                'group' => 'contact_info',
            ],
            [
                'key' => 'management_phone_1',
                'value' => '+963 997 141 223',
                'type' => 'text',
                'group' => 'contact_info',
            ],
            [
                'key' => 'management_phone_2',
                'value' => '+963 11 565 0566',
                'type' => 'text',
                'group' => 'contact_info',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'group' => $setting['group'],
                ]
            );
        }
    }
}
