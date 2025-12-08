<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'label', 'slug', 'parent_id', 'view_name',
        'meta_title', 'meta_description', 'meta_keywords'
    ];

    // Relasi menu utama → submenu
    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    // Relasi submenu → parent
    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }
}
