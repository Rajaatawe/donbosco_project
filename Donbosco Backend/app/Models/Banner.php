<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Banner extends Model
{
    use HasTranslations;
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'button_text',
        'button_url',
        'sort_order',
        'status'
    ];
    public $translatable = ['title', 'subtitle', 'button_text'];
    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'button_text' => 'array',
    ];
}
