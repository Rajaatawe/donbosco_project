<?php

namespace App\Repositories;

use App\Models\Event;
use App\Traits\HasTranslation;

class EventRepository
{
    use HasTranslation;

    protected $eventModel;

    public function __construct(Event $eventModel)
    {
        $this->eventModel = $eventModel;
    }

    public function get_published_events()
    {
        $events = $this->eventModel->where('status', 'published')
            ->orderBy('is_featured', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        $events->getCollection()->transform(function ($event) {
            return [
                'id' => $event->id,
                'title' => $this->translateField($event, 'title'),
                'slug' => $event->slug,
                'description' => $this->translateField($event, 'description'),
                'location' => $this->translateField($event, 'location'),
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'cover_image' => $event->cover_image ? asset('storage/' . $event->cover_image) : null,
                'status' => $event->status,
                'is_featured' => $event->is_featured,
            ];
        });

        return $events->toArray();
    }

    public function get_event_details($slug)
    {
        $event = $this->eventModel->where('status', 'published')->where('slug', $slug)->firstOrFail();

        return [
            'id' => $event->id,
            'title' => $this->translateField($event, 'title'),
            'slug' => $event->slug,
            'description' => $this->translateField($event, 'description'),
            'location' => $this->translateField($event, 'location'),
            'start_time' => $event->start_time,
            'end_time' => $event->end_time,
            'cover_image' => $event->cover_image ? asset('storage/' . $event->cover_image) : null,
            'status' => $event->status,
            'is_featured' => $event->is_featured,
        ];
    }
}
