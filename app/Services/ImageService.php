<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    const DEFAULT_IMAGE_PATH = 'defaults/room-placeholder.jpg';
    const IMAGE_QUALITY = 80;
    const MAX_WIDTH = 1200;
    const MAX_HEIGHT = 800;

    public function optimizeAndStore($image, $path)
    {
        // Create Intervention Image instance
        $img = Image::make($image);

        // Resize if needed while maintaining aspect ratio
        if ($img->width() > self::MAX_WIDTH || $img->height() > self::MAX_HEIGHT) {
            $img->resize(self::MAX_WIDTH, self::MAX_HEIGHT, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Convert to JPG and optimize
        $img->encode('jpg', self::IMAGE_QUALITY);

        // Generate unique filename
        $filename = uniqid('room_') . '.jpg';
        $fullPath = $path . '/' . $filename;

        // Store the optimized image
        Storage::disk('public')->put($fullPath, $img->stream());

        return $fullPath;
    }

    public function getDefaultImageUrl()
    {
        if (!Storage::disk('public')->exists(self::DEFAULT_IMAGE_PATH)) {
            $this->createDefaultImage();
        }
        return asset('storage/' . self::DEFAULT_IMAGE_PATH);
    }

    private function createDefaultImage()
    {
        // Create a simple placeholder image
        $img = Image::canvas(600, 400, '#f0f0f0');

        // Add some text
        $img->text('No Image Available', 300, 180, function($font) {
            $font->size(24);
            $font->color('#666666');
            $font->align('center');
            $font->valign('middle');
        });

        // Add a camera icon or similar placeholder symbol
        $img->text('📷', 300, 220, function($font) {
            $font->size(60);
            $font->align('center');
            $font->valign('middle');
        });

        // Ensure the directory exists
        Storage::disk('public')->makeDirectory('defaults');

        // Save the image
        Storage::disk('public')->put(
            self::DEFAULT_IMAGE_PATH,
            $img->encode('jpg', 90)
        );
    }
}
