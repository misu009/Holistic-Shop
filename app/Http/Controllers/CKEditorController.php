<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $path = $file->store('uploads', 'public');

            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }
    public function deleteImage(Request $request)
    {
        $url = $request->input('url');

        if (!$url) return response()->json(['error' => 'No URL provided.'], 400);

        $path = str_replace(asset('storage') . '/', '', $url);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['message' => 'Deleted successfully']);
        }

        return response()->json(['error' => 'File not found.'], 404);
    }
}
