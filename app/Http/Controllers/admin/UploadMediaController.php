<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadMediaController extends Controller
{
    protected $allowedMimes = [
        // Images
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        // Videos
        'video/mp4',
        'video/quicktime',
        'video/x-msvideo',
        'video/x-ms-wmv',
    ];
    public function uploadTemporary(Request $request)
    {
        $validator = validator($request->all(), [
            'filepond' => 'required|file|mimes:jpeg,jpg,png,gif,mp4,mov,avi,wmv|max:20480'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($request->hasFile('filepond')) {
            $file = $request->file('filepond');

            // Double-check MIME type
            if (!in_array($file->getMimeType(), $this->allowedMimes)) {
                return response()->json(['error' => 'Invalid file type'], 400);
            }

            $path = $file->store('temp', 'local');
            return response($path);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function removeTemporary(Request $request)
    {
        if ($request->getContent()) {
            Storage::delete($request->getContent());
            return response()->json(['removed' => true]);
        }
        return response()->json(['error' => 'No file specified'], 400);
    }
}
