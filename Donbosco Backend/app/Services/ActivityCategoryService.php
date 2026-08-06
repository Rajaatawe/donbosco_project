<?php

namespace App\Services;

use App\Repositories\ActivityCategoryRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class ActivityCategoryService
{
    protected $categoryRepository;
    protected $locale;
    public function __construct(ActivityCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->locale = App::getLocale();
    }

    public function get_all_categories()
    {

        $cacheKey = $this->locale == "ar" ? "ar:activity_categories_all" : "en:activity_categories_all";

        return Cache::tags(["activity_categories_list"])->remember(
            $cacheKey,
            604800, // أسبوع
            function () {
                return $this->categoryRepository->get_all_categories();
            }
        );
    }
}
