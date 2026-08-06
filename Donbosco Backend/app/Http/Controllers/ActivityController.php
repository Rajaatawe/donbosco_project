<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityFormRequest;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    protected $activityService;
    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }
    public function get_published_activities(ActivityFormRequest $request)
    {
        return $this->activityService->get_published_activities($request->validated());
    }
}
