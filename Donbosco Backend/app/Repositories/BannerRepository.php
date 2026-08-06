<?php

namespace App\Repositories;

use App\Models\Banner;
use App\Traits\HasTranslation;

class BannerRepository
{
    use HasTranslation;
    protected $bannerModel;
    public function __construct(Banner $bannerModel)
    {
        $this->bannerModel = $bannerModel;
    }
    public function get_active_banners()
    {

        $initialBanners = $this->bannerModel->where('status', 'active')->orderBy('sort_order', 'asc')->get();
        return $initialBanners->map(function ($banner) {
            return [
                'id' => $banner->id,
                'title' => $this->translateField($banner, 'title'),
                'subtitle' => $this->translateField($banner, 'subtitle'),
                'image_url' => asset('storage/' . $banner->image),
                'button_text' => $this->translateField($banner, 'button_text'),
                'button_url' => $banner->button_url,
                'sort_order' => $banner->sort_order,
                'status' => $banner->status,
                'created_at' => $banner->created_at,
                'updated_at' => $banner->updated_at,
            ];
        });
    }
}
