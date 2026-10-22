<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title',
        'youtube_url',
        'youtube_id',
        'description',
        'duration',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Smart parser to extract the 11-character YouTube ID from various YouTube URL formats or raw ID.
     */
    public static function parseYoutubeId(?string $input): ?string
    {
        if (empty($input)) {
            return null;
        }

        $input = trim($input);

        // If it's already an 11-char ID without slashes or params
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $input)) {
            return $input;
        }

        // Standard watch URL: youtube.com/watch?v=XXXXXXXXXXX
        if (preg_match('/[?&]v=([a-zA-Z0-9_-]{11})/', $input, $matches)) {
            return $matches[1];
        }

        // Short URL: youtu.be/XXXXXXXXXXX
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $input, $matches)) {
            return $matches[1];
        }

        // Embed URL: youtube.com/embed/XXXXXXXXXXX
        if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/', $input, $matches)) {
            return $matches[1];
        }

        // Shorts URL: youtube.com/shorts/XXXXXXXXXXX
        if (preg_match('/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/', $input, $matches)) {
            return $matches[1];
        }

        // Live URL: youtube.com/live/XXXXXXXXXXX
        if (preg_match('/youtube\.com\/live\/([a-zA-Z0-9_-]{11})/', $input, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Automatically sync youtube_id when youtube_url is set, if youtube_id is not explicitly provided.
     */
    public function setYoutubeUrlAttribute($value)
    {
        $this->attributes['youtube_url'] = $value;
        if (!empty($value)) {
            $parsedId = self::parseYoutubeId($value);
            if ($parsedId) {
                $this->attributes['youtube_id'] = $parsedId;
            }
        }
    }

    /**
     * Get high quality YouTube thumbnail URL.
     */
    public function getThumbnailUrlAttribute(): string
    {
        if (empty($this->youtube_id)) {
            return asset('images/video-placeholder.jpg');
        }
        return "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg";
    }

    /**
     * Get embed URL.
     */
    public function getEmbedUrlAttribute(): string
    {
        return "https://www.youtube.com/embed/{$this->youtube_id}";
    }
}
