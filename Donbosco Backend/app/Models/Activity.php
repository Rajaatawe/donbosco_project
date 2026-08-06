<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasTranslations, SoftDeletes;
    protected $fillable = [
        'activity_category_id',
        'title',
        'slug',
        'summary',
        'content',
        'cover_image',
        'status',
        'is_featured'
    ];
    public $translatable = [
        'title',
        'summary',
        'content'
    ];
    protected $casts = [
        'title' => 'array',
        'summary' => 'array',
        'content' => 'array',
    ];
    public function activityCategory()
    {
        return $this->belongsTo(ActivityCategory::class);
    }
}



