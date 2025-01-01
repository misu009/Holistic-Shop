<?php

namespace App\Traits\admin;

use Illuminate\Support\Facades\Storage;

trait MediaContentTrait
{
    public function deleteImage($productId, $imageId, $model)
    {
        $product = $model::find($productId);
        $image = $product->media()->find($imageId);
        if (Storage::exists('public/' . $image->path)) {
            Storage::delete('public/' . $image->path);
        }
        $image->delete();
    }

    public function changeImageOrder($productId, $imageId, $model)
    {
        $product = $model::find($productId);
        $image = $product->media()->find($imageId);
        $image->update(['order' => request()->order]);
    }
}