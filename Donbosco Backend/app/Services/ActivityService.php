<?php

namespace App\Services;

use App\Repositories\ActivityRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class ActivityService
{
    protected $activityRepository;
    protected $locale;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
        $this->locale = App::getLocale();
    }
    public function get_published_activities(array $request)
    {
        $categoryId = $request['category_id'] ?? null;
        $page = request('page', 1);
        $cacheKey = $this->locale == "ar" ? "ar:activities_page_" . $page . "_category_" . $categoryId : "en:activities_page_" . $page . "_category_" . $categoryId;
        return Cache::tags(["activity_list"])->remember(
            $cacheKey,
            604800,
            function () use ($categoryId) {
                return $this->activityRepository->get_published_activities($categoryId);
            }
        );
    }
}
