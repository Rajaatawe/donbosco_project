<?php

namespace App\Repositories;

use App\Models\News;
use App\Traits\HasTranslation;

class NewsRepository
{
    use HasTranslation;

    protected $newsModel;

    public function __construct(News $newsModel)
    {
        $this->newsModel = $newsModel;
    }

    public function get_published_news()
    {
        $initialNews = $this->newsModel->where('status', 'published')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $initialNews->getCollection()->transform(function ($news) {
            return [
                'id' => $news->id,
                'title' => $this->translateField($news, 'title'),
                'slug' => $news->slug,
                'summary' => $this->translateField($news, 'summary'),
                'content' => $this->translateField($news, 'content'),
                'image_url' => $news->cover_image ? asset('storage/' . $news->cover_image) : null,
                'status' => $news->status,
                'is_featured' => $news->is_featured,
                'published_at' => $news->published_at,
                'created_at' => $news->created_at,
            ];
        });

        return $initialNews->toArray();
    }


    public function get_news_details($slug)
    {
        $news = $this->newsModel->where('status', 'published')->where('slug', $slug)->firstOrFail();

        return [
            'id' => $news->id,
            'title' => $this->translateField($news, 'title'),
            'slug' => $news->slug,
            'summary' => $this->translateField($news, 'summary'),
            'content' => $this->translateField($news, 'content'),
            'image_url' => $news->cover_image ? asset('storage/' . $news->cover_image) : null,
            'status' => $news->status,
            'is_featured' => $news->is_featured,
            'published_at' => $news->published_at,
            'created_at' => $news->created_at,
        ];
    }
}
