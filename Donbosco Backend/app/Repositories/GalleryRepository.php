<?php


namespace App\Repositories;

use App\Models\GalleryAlbum;
use App\Traits\HasTranslation;
class GalleryRepository
{
    use HasTranslation;
    protected $galleryAlbumModel;
    public function __construct(GalleryAlbum $galleryAlbumModel)
    {
        $this->galleryAlbumModel = $galleryAlbumModel;
    }
    public function get_albums()
    {
        $initialGalleryAlbum = $this->galleryAlbumModel->where('status', 'active')
        ->orderBy('sort_order', 'asc')->get();
        return $initialGalleryAlbum->map(function ($album) {
            return [
                'id' => $album->id,
                'title' => $this->translateField($album, 'title'),
                'slug' => $album->slug,
                'description' => $this->translateField($album, 'description'),
                'cover_image_url' => asset('storage/' . $album->cover_image),
                'sort_order' => $album->sort_order,
                'created_at' => $album->created_at,
                'updated_at' => $album->updated_at,
            ];
        });
    }
    public function get_images_by_album_id($album_id)
    {
        $album = $this->galleryAlbumModel->find($album_id);
        if(!$album || $album->status !== 'active') {
            return false;
        }
        return $album->galleryImages()->orderBy('sort_order', 'asc')->get()->map(function ($image) {
            return [
                'id' => $image->id,
                'gallery_album_id' => $image->gallery_album_id,
                'caption' => $this->translateField($image, 'caption'),
                'image_url' => asset('storage/' . $image->image),
                'sort_order' => $image->sort_order,
                'created_at' => $image->created_at,
                'updated_at' => $image->updated_at,
            ];
        });
    }
}
