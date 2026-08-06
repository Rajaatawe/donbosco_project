<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryAlbum extends Model
{
    // استدعاء HasSortable بدلاً من SortableTrait
    use HasTranslations, SoftDeletes ;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'slug',
        'status',
        'sort_order',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public $translatable = [
        'title',
        'description'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class);
    }
}
