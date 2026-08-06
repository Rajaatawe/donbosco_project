<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
class Event extends Model
{
    use SoftDeletes;
    use HasTranslations;
    protected $fillable = [
        'title',
        'description',
        'slug',
        'start_time',
        'end_time',
        'location',
        'cover_image',
        'status',
        'is_featured',
    ];
    public $translatable = ['title', 'description','location'];
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'location' => 'array',
    ];
}
