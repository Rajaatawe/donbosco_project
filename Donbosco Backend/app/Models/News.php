<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
class News extends Model
{
    use HasTranslations, SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'cover_image',
        'published_at',
        'status',
        'is_featured'
    ];
    public $translatable = ['title', 'summary', 'content'];
    protected $casts = [
        'title' => 'array',
        'summary' => 'array',
        'content' => 'array',
    ];
}
