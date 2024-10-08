<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DvUserRole extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active'];

    public function users()
    {
        return $this->belongsToMany(DvUser::class, 'dv_users_roles_has_dv_users', 'dv_users_roles_id', 'dv_users_id');
    }
}


