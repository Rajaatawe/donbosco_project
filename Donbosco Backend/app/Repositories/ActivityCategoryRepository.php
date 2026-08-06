<?php

namespace App\Repositories;

use App\Models\ActivityCategory;
use App\Traits\HasTranslation;

class ActivityCategoryRepository
{
    use HasTranslation;

    protected $categoryModel;

    public function __construct(ActivityCategory $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    public function get_all_categories()
    {
        $categories = $this->categoryModel->orderBy('created_at', 'desc')->get();

        return $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $this->translateField($category, 'name'),
                'slug' => $category->slug,
                'description' => $this->translateField($category, 'description'),
            ];
        })->toArray();
    }
}
