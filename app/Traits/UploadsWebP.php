<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadsWebP
{
    /**
     * Upload an image, convert it to WebP, and save it to storage.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string $disk
     * @param int $quality
     * @return string The relative path to the saved file.
     */
    public function uploadImage(UploadedFile $file, string $folder, string $disk = 'public', int $quality = 80): string
    {
        $image = null;
        $extension = strtolower($file->getClientOriginalExtension());
        
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $image = @imagecreatefromjpeg($file->getPathname());
                break;
            case 'png':
                $image = @imagecreatefrompng($file->getPathname());
                // Handle transparency for PNG
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                break;
            case 'gif':
                $image = @imagecreatefromgif($file->getPathname());
                 // Handle transparency for GIF
                 if ($image) {
                    imagepalettetotruecolor($image);
                }
                break;
            case 'webp':
                // If already webp, just store it directly but rename it to ensure uniqueness
                $filename = time() . '_' . uniqid() . '.webp';
                $path = $file->storeAs($folder, $filename, $disk);
                return 'storage/' . $path; // Return path with storage prefix
        }

        if (!$image) {
            // Fallback for unsupported types (or if GD fails): just store original
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = $file->storeAs($folder, $filename, $disk);
            return 'storage/' . $path;
        }

        // Resize image if width > 1200px
        $maxWidth = 1200;
        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = floor($height * ($maxWidth / $width));

            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Handle transparency for new image
            if ($extension == 'png' || $extension == 'gif') {
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image); // Free old image memory
            $image = $newImage;
        }

        // Generate WebP filename
        $filename = time() . '_' . uniqid() . '.webp';
        
        // Create a temporary stream to save the WebP content
        ob_start();
        imagewebp($image, null, $quality); // Output to buffer
        $webpData = ob_get_contents();
        ob_end_clean();
        
        imagedestroy($image);

        // Store the WebP data using Laravel Storage
        // Note: Storage::put expects path relative to disk root
        Storage::disk($disk)->put($folder . '/' . $filename, $webpData);

        // Return path suitable for database (often includes 'storage/' prefix if public link)
        // Adjust based on project convention. 
        // Project convention seems to be 'storage/folder/filename.ext'
        // $file->storeAs returns 'folder/filename.ext'
        // But the controllers were manually doing 'storage/products/' . $filename
        
        // Let's verify standard Laravel storage link behavior.
        // 'storage/app/public' is linked to 'public/storage'.
        // So 'storage/products/foo.webp' in DB means URL is 'domain/storage/products/foo.webp'
        
        return 'storage/' . $folder . '/' . $filename;
    }
}
