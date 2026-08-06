<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        return response()->json($this->eventService->get_published_events());
    }

    public function show($slug)
    {
        return response()->json($this->eventService->get_event_details($slug));
    }
}
