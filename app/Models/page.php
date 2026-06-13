<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'label', 'slug', 'parent_id', 'view_name',
        'meta_title', 'meta_description', 'meta_keywords',
        'content', 'type', 'is_published', 'show_in_menu', 'sort_order',
        'og_image', 'hero_image', 'hero_subtitle'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_in_menu' => 'boolean',
        'sort_order'   => 'integer',
        'parent_id'    => 'integer',
    ];

    // Relasi menu utama → submenu
    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('sort_order');
    }

    // Relasi submenu → parent
    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    // ---------- Scopes ----------
    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }

    public function scopeMenu($q)
    {
        return $q->where('show_in_menu', true)
                 ->where('is_published', true);
    }

    public function scopeCustom($q)
    {
        return $q->where('type', 'custom');
    }

    public function scopeSystem($q)
    {
        return $q->where('type', 'system');
    }

    public function getUrlAttribute(): string
    {
        if (!$this->slug || $this->slug === '#') return '#';
        if ($this->slug === '/') return url('/');
        return url('/' . ltrim($this->slug, '/'));
    }
}
