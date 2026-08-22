<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Drop-in replacement for UploadedFile::store() that re-encodes images at a
 * reduced quality before saving, so uploaded photos take up less disk space.
 * Non-image files (e.g. career post videos) are stored untouched.
 */
class ImageCompressor
{
    public static function store(UploadedFile $file, string $folder, string $disk = 'public', int $quality = 60): string
    {
        $mime = $file->getMimeType();
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'jpg';
        $filename = Str::random(40) . '.' . $extension;
        $relativePath = trim($folder, '/') . '/' . $filename;

        $source = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($file->getRealPath()),
            'image/png' => @imagecreatefrompng($file->getRealPath()),
            'image/webp' => @imagecreatefromwebp($file->getRealPath()),
            default => null,
        };

        if (!$source) {
            // Unsupported format (gif, video, etc.) — store as-is.
            return $file->storeAs($folder, $filename, $disk);
        }

        Storage::disk($disk)->makeDirectory($folder);
        $fullPath = Storage::disk($disk)->path($relativePath);

        if ($mime === 'image/png') {
            imagesavealpha($source, true);
            imagepng($source, $fullPath, 6);
        } elseif ($mime === 'image/webp') {
            imagewebp($source, $fullPath, $quality);
        } else {
            imagejpeg($source, $fullPath, $quality);
        }

        imagedestroy($source);

        return $relativePath;
    }
}
