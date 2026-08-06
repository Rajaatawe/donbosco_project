<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryImage extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'gallery_album_id',
        'image',
        'caption',
        'sort_order',
    ];

    public $translatable = [
        'caption'
    ];

    protected $casts = [
        'caption' => 'array',
    ];

    public function galleryAlbum()
    {
        return $this->belongsTo(GalleryAlbum::class);
    }
}
