<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Services\AppConfigService;
use Illuminate\Http\Request;

class AppConfigController extends Controller
{
    protected $appConfigService;
    public function __construct(AppConfigService $appConfigService)
    {
        $this->appConfigService = $appConfigService;
    }
    public function get_active_banners()
    {
        $result = $this->appConfigService->get_active_banners();
        return response()->json($result);
    }
    public function get_published_pages()
    {
        $result = $this->appConfigService->get_published_pages();
        return response()->json($result);
    }
    public function get_site_settings()
    {
        $result = $this->appConfigService->get_site_settings();
        return response()->json($result);
    }
}
