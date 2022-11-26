<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\IndexRequest as ProviderIndexRequest;
use App\Http\Resources\PhotoGalleryResource;
use App\Models\PhotoGallery;
use Illuminate\Support\Facades\Storage;

class PhotosGallery extends Controller
{
    public function getPhotos(ProviderIndexRequest $request)
    {
        $photos = $request->user()->provider->gallery_images;
        return response()->json([
            'resource' => PhotoGalleryResource::collection($photos)
        ]);
    }

    public function remove(ProviderIndexRequest $request, PhotoGallery $photo)
    {
        Storage::disk('public')->delete($photo->photo);

        $request->user()->provider->gallery_images()->where('id', $photo->id)->delete();

        return response()->json([
            'resource' => true
        ]);
    }
}
