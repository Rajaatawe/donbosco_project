<?php
namespace App\Observers;
use App\Models\Event;
use Illuminate\Support\Facades\Cache;



class EventObserver
{
    public function created(Event $event): void { $this->clearCache($event); }
    public function updated(Event $event): void { $this->clearCache($event); }
    public function deleted(Event $event): void { $this->clearCache($event); }

    protected function clearCache(Event $event): void
    {
        Cache::tags(['event_list'])->flush();

        Cache::forget('ar:event_details_' . $event->slug);
        Cache::forget('en:event_details_' . $event->slug);
    }
}






