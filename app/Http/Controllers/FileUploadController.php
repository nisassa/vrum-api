<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

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
                    $folderName = 'photo_gallery';
                }

                $file = $request->photo;
                $filePath = $this->handleFileUpload($file, $folderName);
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
    public function handleFileUpload($file, string $folderName)
    {
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'.';
        $fileName .= Str::random(7).'.';
        $fileName .= $file->getClientOriginalExtension();

        return Storage::disk('public')->putFileAs("userfiles/{$folderName}", $file, $fileName, 'public');
    }
}
