<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DvUser extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'username', 'password', 'email', 'is_active'];

    public function roles()
    {
        return $this->belongsToMany(DvUserRole::class, 'dv_users_roles_has_dv_users', 'dv_users_id', 'dv_users_roles_id');
    }
}
