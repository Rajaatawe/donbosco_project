<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\News;
use App\Observers\ActivityObserver;
use App\Observers\NewsObserver;
use App\Models\ActivityCategory;
use App\Observers\ActivityCategoryObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\Program;
use App\Observers\ProgramObserver;
use App\Models\Event;
use App\Observers\EventObserver;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Activity::observe(ActivityObserver::class);
        News::observe(NewsObserver::class);
        Program::observe(ProgramObserver::class);
        Event::observe(EventObserver::class);
        ActivityCategory::observe(ActivityCategoryObserver::class);

    }
}
