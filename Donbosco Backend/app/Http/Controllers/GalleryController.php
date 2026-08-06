<?php

namespace App\Http\Controllers;

use App\Services\GalleryService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected $galleryService;
    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }
    public function get_albums(){
        return $this->galleryService->get_albums();
    }
    public function get_images_by_album_id($album_id){
        $images = $this->galleryService->get_images_by_album_id($album_id);
        if($images === false) {
            return response()->json(['message' => __('messages.album_not_found')], 404);
        }
        return $images;
    }
}
