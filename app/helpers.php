<?php

use Illuminate\Support\Facades\Storage;

function transformedUrlAttachment($path)
{
    if ($path && Storage::disk('public')->exists($path)) {
        return asset('storage/' . ltrim($path, '/'));
    }

    return asset('image/no_image.jpg'); // pastikan ini berada di public/images/
}