<?php

namespace App\Repositories;

use App\Models\SiteSetting;
use App\Traits\HasTranslation;

class SiteSettingRepository
{
    use HasTranslation;
    protected $siteSettingModel;
    public function __construct(SiteSetting $siteSettingModel)
    {
        $this->siteSettingModel = $siteSettingModel;
    }
    public function get_site_settings()
    {
        $initialSiteSettings = $this->siteSettingModel::all();
        return $initialSiteSettings->map(function ($setting) {
            return [
                'id' => $setting->id,
                'key' => $setting->key,
                'value' => $this->translateField($setting, 'value'),
                'type' => $setting->type,
                'group' => $setting->group,
                'created_at' => $setting->created_at,
                'updated_at' => $setting->updated_at,
            ];
        });
    }
}
