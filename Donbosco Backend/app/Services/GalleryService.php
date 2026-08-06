<?php

namespace App\Services;

use App\Repositories\GalleryRepository;

class GalleryService
{
    protected $galleryRepository;
    public function __construct(GalleryRepository $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
    }
    public function get_albums(){
        return $this->galleryRepository->get_albums();
    }
    public function get_images_by_album_id($album_id){
        return $this->galleryRepository->get_images_by_album_id($album_id);
    }
}
