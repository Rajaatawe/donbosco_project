<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Traits\HasTranslation;

class ActivityRepository
{
    use HasTranslation;
    protected $activityModel;
    public function __construct(Activity $activityModel)
    {
        $this->activityModel = $activityModel;
    }
    public function get_published_activities($categoryId)
    {

        $initialActivities = $this->activityModel->where('status', 'published')
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('activity_category_id', $categoryId);
            })
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $initialActivities->getCollection()->transform(function ($activity) {
            return [
                'id' => $activity->id,
                'activity_category_id' => $activity->activity_category_id,
                'title' => $this->translateField($activity, 'title'),
                'slug' => $activity->slug,
                'summary' => $this->translateField($activity, 'summary'),
                'content' => $this->translateField($activity, 'content'),
                'image_url' => $activity->cover_image ? asset('storage/' . $activity->cover_image) : null,
                'status' => $activity->status,
                'is_featured' => $activity->is_featured,
                'created_at' => $activity->created_at,
                'updated_at' => $activity->updated_at,
            ];
        });
        return $initialActivities->toArray();
    }
}
