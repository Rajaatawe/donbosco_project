<?php

namespace App\Repositories;

use App\Models\Page;
use App\Traits\HasTranslation;
class PageRepository
{
    use HasTranslation;
    protected $pageModel;
    public function __construct(Page $pageModel)
    {
        $this->pageModel = $pageModel;
    }
    public function get_published_pages()
    {
        $initialPages = $this->pageModel::where('status', 'published')->get();
        return $initialPages->map(function ($page) {
            return [
                'id' => $page->id,
                'title' => $this->translateField($page, 'title'),
                'content' => $this->translateField($page, 'content'),
                'slug' => $page->slug,
                'status' => $page->status,
                'image_url' => $page->image ? asset('storage/' . $page->image) : null,
                'created_at' => $page->created_at,
                'updated_at' => $page->updated_at,
            ];
        });
    }
}
