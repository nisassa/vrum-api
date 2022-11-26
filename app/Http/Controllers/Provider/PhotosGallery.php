<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\IndexRequest as ProviderIndexRequest;
use App\Http\Resources\PhotoGalleryResource;

class PhotosGallery extends Controller
{
    public function getPhotos(ProviderIndexRequest $request)
    {
        $photos = $request->user()->provider->gallery_images;
        return response()->json([
            'resource' => PhotoGalleryResource::collection($photos)
        ]);
    }
}
