<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index()
    {
        $news = $this->newsService->get_published_news();
        return response()->json($news);
    }

    public function show($slug)
    {
        $newsDetails = $this->newsService->get_news_details($slug);
        return response()->json($newsDetails);
    }
}
