<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LinkMetadataController extends Controller
{
    public function fetch(Request $request)
    {
        $url = $request->query('url');

        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['success' => 0, 'message' => 'Invalid URL'], 400);
        }

        try {
            $response = Http::get($url);
            $html = $response->body();

            // Use regex or a parser to extract meta tags
            preg_match('/<title>(.*?)<\/title>/i', $html, $title);
            preg_match('/<meta name="description" content="(.*?)"/i', $html, $description);
            preg_match('/<meta property="og:image" content="(.*?)"/i', $html, $image);

            return response()->json([
                'success' => 1,
                'meta' => [
                    'title' => $title[1] ?? '',
                    'description' => $description[1] ?? '',
                    'image' => $image[1] ?? '',
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'message' => 'Failed to fetch metadata'], 500);
        }
    }
}