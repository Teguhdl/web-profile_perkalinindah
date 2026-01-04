<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    
    protected $fillable = ['admin_id', 'action', 'description', 'subject_type', 'subject_id'];
    
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }
}
