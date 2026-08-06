<?php

namespace App\Observers;

use App\Models\Activity;
use Illuminate\Support\Facades\Cache;

class ActivityObserver
{
    /**
     * Handle the Activity "created" event.
     */
    public function created(Activity $activity): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Activity "updated" event.
     */
    public function updated(Activity $activity): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Activity "deleted" event.
     */
    public function deleted(Activity $activity): void
    {
        $this->clearCache();
    }
    protected function clearCache(): void
    {
        Cache::tags(['activity_list'])->flush();
    }
}
