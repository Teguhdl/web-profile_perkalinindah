<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';

    protected $fillable = ['name', 'email', 'password', 'role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permission)
    {
        if (!$this->role) return false;
        
        // Super Admin access
        if ($this->role->name === 'Super Admin') return true;
        
        return in_array($permission, $this->role->permissions ?? []);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
