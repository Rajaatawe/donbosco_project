<?php

namespace App\Observers;

use App\Models\News;
use Illuminate\Support\Facades\Cache;

class NewsObserver
{
    public function created(News $news): void { $this->clearCache($news); }
    public function updated(News $news): void { $this->clearCache($news); }
    public function deleted(News $news): void { $this->clearCache($news); }

    protected function clearCache(News $news): void
    {
        Cache::tags(['news_list'])->flush();

        Cache::forget('ar:news_details_' . $news->slug);
        Cache::forget('en:news_details_' . $news->slug);
    }
}
