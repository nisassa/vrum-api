<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $allowedImagesMimes = 'jpg,jpeg,bmp,png';
        switch ($request->entity) {
            case in_array($request->entity, ['photo_gallery', 'user']):
                $validator = Validator::make($request->all(), [
                    'photo' => 'required|mimes:'.$allowedImagesMimes.'|max:1000'
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->getMessageBag()
                    ]);
                }

                $folderName = 'user';
                if ($request->entity === 'photo_gallery') {
                    $totalImages = $request->user()->provider->gallery_images()->count();
                    $totalImages++;
                    if ($totalImages > config('app.max_gallery_images')) {
                        abort(403 );
                    }
                    $folderName = 'photo_gallery';
                }

                $file = $request->photo;
                $filePath = $this->handleFileUpload($file, $folderName, $request->entity, $request->user());

                $response = [
                    'success' => true,
                    'document' => [
                        'name' => $file->getClientOriginalName(),
                        'path' => $filePath,
                    ],
                ];
                break;
        }

        return response()->json($response?? []);
    }

    /**
     * @param $file
     * @param string $folderName
     * @return false|string
     */
    private function handleFileUpload($file, string $folderName, string $entity, User $user)
    {
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'.';
        $fileName .= Str::random(7).'.';
        $fileName .= $file->getClientOriginalExtension();

        $path = "userfiles/{$folderName}";

        if ($entity === 'photo_gallery') {
            // create the entity
            $user->provider->gallery_images()->create([
                'name' => $fileName,
                'photo' => $path
            ]);
        }

        return Storage::disk('public')->putFileAs($path, $file, $fileName, 'public');
    }
}
