<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaLibrary extends Model
{
    protected $table = 'media_library';

    protected $fillable = [
        'filename', 'path', 'mime', 'size', 'alt', 'title', 'uploaded_by',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function getUrlAttribute(): string
    {
        return asset($this->path);
    }

    public function getReadableSizeAttribute(): string
    {
        $size = (int) $this->size;
        if ($size < 1024) return $size . ' B';
        if ($size < 1024 * 1024) return round($size / 1024, 1) . ' KB';
        return round($size / (1024 * 1024), 2) . ' MB';
    }

    public function getIsImageAttribute(): bool
    {
        return $this->mime && str_starts_with($this->mime, 'image/');
    }
}
