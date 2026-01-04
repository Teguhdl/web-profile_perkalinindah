<?php

$source = __DIR__ . '/public/assets/web/dashboard/dashboard.jpg';
$destination = __DIR__ . '/public/assets/web/dashboard/dashboard_optimized.jpg';

if (!file_exists($source)) {
    die("Source file not found.\n");
}

list($width, $height) = getimagesize($source);
$ratio = $width / $height;
$newWidth = 1920;
$newHeight = 1920 / $ratio;

// Resample
$image_p = imagecreatetruecolor($newWidth, $newHeight);
$image = imagecreatefromjpeg($source);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

// Output
imagejpeg($image_p, $destination, 75); // 75% quality
imagedestroy($image_p);
imagedestroy($image);

echo "Image optimized successfully: $destination\n";

// Backup original
rename($source, __DIR__ . '/public/assets/web/dashboard/dashboard_original.jpg');
// Replace original with optimized
rename($destination, $source);
echo "Replaced original file.\n";
