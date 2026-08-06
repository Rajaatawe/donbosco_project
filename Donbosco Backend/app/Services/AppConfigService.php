<?php

namespace App\Services;

use App\Repositories\BannerRepository;
use App\Repositories\PageRepository;
use App\Repositories\SiteSettingRepository;

class AppConfigService
{

    protected $bannerRepository;
    protected $pageRepository;
    protected $siteSettingRepository;
    public function __construct(BannerRepository $bannerRepository, PageRepository $pageRepository, SiteSettingRepository $siteSettingRepository)
    {
        $this->bannerRepository = $bannerRepository;
        $this->pageRepository = $pageRepository;
        $this->siteSettingRepository = $siteSettingRepository;
    }
    public function get_active_banners()
    {
        return $this->bannerRepository->get_active_banners();
    }
    public function get_published_pages()
    {
        return $this->pageRepository->get_published_pages();
    }
    public function get_site_settings()
    {
        return $this->siteSettingRepository->get_site_settings();
    }
}
