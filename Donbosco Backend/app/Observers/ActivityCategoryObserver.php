<?php

namespace App\Observers;

use App\Models\ActivityCategory;
use Illuminate\Support\Facades\Cache;

class ActivityCategoryObserver
{
    public function created(ActivityCategory $activityCategory): void { $this->clearCache(); }
    public function updated(ActivityCategory $activityCategory): void { $this->clearCache(); }
    public function deleted(ActivityCategory $activityCategory): void { $this->clearCache(); }

    protected function clearCache(): void
    {
        Cache::tags(['activity_categories_list'])->flush();
    }
}
