<?php

namespace App\Services;

use App\Repositories\NewsRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class NewsService
{
    protected $newsRepository;
    protected $locale;
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
        $this->locale = App::getLocale();
    }

    public function get_published_news()
    {

        $page = request('page', 1);
        $cacheKey = $this->locale == "ar" ? "ar:news_page_" . $page : "en:news_page_" . $page;

        return Cache::tags(["news_list"])->remember(
            $cacheKey,
            604800,
            function () {
                return $this->newsRepository->get_published_news();
            }
        );
    }

    public function get_news_details($slug)
    {
        $cacheKey = $this->locale == "ar" ? "ar:news_details_" . $slug : "en:news_details_" . $slug;

        return Cache::remember(
            $cacheKey,
            604800,
            function () use ($slug) {
                return $this->newsRepository->get_news_details($slug);
            }
        );
    }
}
