<?php

namespace App\Services;

use App\Models\MediaItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    /**
     * Store and process an uploaded file.
     */
    public function processUpload(UploadedFile $file, array $attributes = []): MediaItem
    {
        $mime = $file->getMimeType() ?: $file->getClientMimeType();
        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());
        $title = !empty($attributes['title']) ? $attributes['title'] : pathinfo($originalName, PATHINFO_FILENAME);

        $fileType = $this->determineFileType($mime, $extension);

        if ($fileType === 'image') {
            return $this->processImage($file, $title, $attributes);
        }

        // Handle Audio, Video, PDF and generic files
        $subFolder = match ($fileType) {
            'audio' => 'media/audio',
            'video' => 'media/video',
            'pdf' => 'media/documents',
            default => 'media/misc',
        };

        $safeName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '-' . Str::random(6) . '.' . $extension;
        $path = $file->storeAs($subFolder, $safeName, 'public');

        return MediaItem::create([
            'title' => $title,
            'file_name' => $safeName,
            'original_name' => $originalName,
            'file_path' => $path,
            'file_type' => $fileType,
            'mime_type' => $mime,
            'file_size' => $file->getSize(),
            'is_webp' => false,
            'alt_text' => $attributes['alt_text'] ?? null,
            'description' => $attributes['description'] ?? null,
        ]);
    }

    /**
     * Process image and convert to WebP format for high-speed loading.
     */
    protected function processImage(UploadedFile $file, string $title, array $attributes): MediaItem
    {
        $originalName = $file->getClientOriginalName();
        $safeBase = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '-' . Str::random(6);
        $webpFileName = $safeBase . '.webp';
        $relativeFolder = 'media/images';
        $fullDestDir = Storage::disk('public')->path($relativeFolder);

        if (!is_dir($fullDestDir)) {
            mkdir($fullDestDir, 0755, true);
        }

        $fullDestPath = $fullDestDir . DIRECTORY_SEPARATOR . $webpFileName;
        $relativeFilePath = $relativeFolder . '/' . $webpFileName;

        $width = null;
        $height = null;
        $converted = false;

        // Try GD conversion to WebP
        if (extension_loaded('gd') && function_exists('imagewebp')) {
            $sourcePath = $file->getRealPath();
            $imageInfo = @getimagesize($sourcePath);

            if ($imageInfo) {
                $width = $imageInfo[0];
                $height = $imageInfo[1];
                $mime = $imageInfo['mime'];

                $imageResource = match ($mime) {
                    'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($sourcePath),
                    'image/png' => @imagecreatefrompng($sourcePath),
                    'image/gif' => @imagecreatefromgif($sourcePath),
                    'image/webp' => @imagecreatefromwebp($sourcePath),
                    default => @imagecreatefromstring(file_get_contents($sourcePath)),
                };

                if ($imageResource) {
                    // Preserve transparency for PNG/GIF/WEBP
                    imagepalettetotruecolor($imageResource);
                    imagealphablending($imageResource, true);
                    imagesavealpha($imageResource, true);

                    // Convert to WebP with 85 quality compression
                    if (@imagewebp($imageResource, $fullDestPath, 85)) {
                        $converted = true;
                    }
                    imagedestroy($imageResource);
                }
            }
        }

        // Fallback: If GD was unable to convert, store original safely
        if (!$converted) {
            $extension = strtolower($file->getClientOriginalExtension());
            $fallbackName = $safeBase . '.' . $extension;
            $path = $file->storeAs('media/images', $fallbackName, 'public');
            $fileSize = $file->getSize();
            $isWebp = ($extension === 'webp');
            $mimeType = $file->getMimeType();
        } else {
            $path = $relativeFilePath;
            $fileSize = filesize($fullDestPath);
            $isWebp = true;
            $mimeType = 'image/webp';
        }

        return MediaItem::create([
            'title' => $title,
            'file_name' => basename($path),
            'original_name' => $originalName,
            'file_path' => $path,
            'file_type' => 'image',
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
            'width' => $width,
            'height' => $height,
            'is_webp' => $isWebp,
            'alt_text' => $attributes['alt_text'] ?? $title,
            'description' => $attributes['description'] ?? null,
        ]);
    }

    /**
     * Determine file type classification.
     */
    protected function determineFileType(string $mime, string $extension): string
    {
        if (str_starts_with($mime, 'image/') || in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'svg'])) {
            return 'image';
        }

        if (str_starts_with($mime, 'audio/') || in_array($extension, ['mp3', 'wav', 'aac', 'ogg', 'm4a', 'flac'])) {
            return 'audio';
        }

        if (str_starts_with($mime, 'video/') || in_array($extension, ['mp4', 'webm', 'mov', 'avi', 'mkv'])) {
            return 'video';
        }

        if ($mime === 'application/pdf' || $extension === 'pdf') {
            return 'pdf';
        }

        return 'document';
    }

    /**
     * Delete media item from disk and database.
     */
    public function deleteMedia(MediaItem $mediaItem): bool
    {
        if (Storage::disk('public')->exists($mediaItem->file_path)) {
            Storage::disk('public')->delete($mediaItem->file_path);
        }

        return $mediaItem->delete();
    }
}
