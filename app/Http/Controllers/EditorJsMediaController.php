<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EditorJsMediaController extends Controller
{
    public function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json(['success' => 0, 'message' => 'No image uploaded'], 400);
        }

        $file = $request->file('image');
        $path = $file->store("public/editorjs/tmp"); // store in tmp

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => Storage::url($path), // returns /storage/editorjs/tmp/filename.jpg
            ]
        ]);
    }

    public function fetchImageFromUrl(Request $request)
    {
        $url = $request->input('url');
        if (!$url) {
            return response()->json(['success' => 0, 'message' => 'No URL provided'], 400);
        }

        try {
            $contents = file_get_contents($url);
            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename = 'public/editorjs/tmp/' . Str::uuid() . '.' . $extension;

            Storage::put($filename, $contents);

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => Storage::url($filename)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'message' => 'Failed to download image'], 500);
        }
    }
}
