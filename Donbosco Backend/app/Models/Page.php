<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasTranslations, SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status'
    ];
    public $translatable = ['title', 'content'];
    protected $casts = [
        'title' => 'array',
        'content' => 'array',
    ];
}
