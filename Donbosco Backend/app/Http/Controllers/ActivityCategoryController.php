<?php

namespace App\Http\Controllers;

use App\Services\ActivityCategoryService;
use Illuminate\Http\Request;

class ActivityCategoryController extends Controller
{
    protected $categoryService;

    public function __construct(ActivityCategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->get_all_categories();
        return response()->json($categories);
    }
}
