<?php

namespace App\Services;

use App\Repositories\EventRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class EventService
{
    protected $eventRepository;
    protected $locale;
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->locale = App::getLocale();
    }

    public function get_published_events()
    {
        $page = request('page', 1);
        $cacheKey = $this->locale == "ar" ? "ar:events_page_" . $page : "en:events_page_" . $page;

        return Cache::tags(["event_list"])->remember(
            $cacheKey, 604800, function () {
                return $this->eventRepository->get_published_events();
            }
        );
    }

    public function get_event_details($slug)
    {
        $cacheKey = $this->locale == "ar" ? "ar:event_details_" . $slug : "en:event_details_" . $slug;

        return Cache::remember(
            $cacheKey, 604800, function () use ($slug) {
                return $this->eventRepository->get_event_details($slug);
            }
        );
    }
}
