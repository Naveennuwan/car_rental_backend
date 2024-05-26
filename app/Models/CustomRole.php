<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Role;
class CustomRole extends SpatieRole
{
    use HasFactory;

    public function custom_permissions()
    {
        return $this->belongsToMany(CustomPermission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }

    public function userCreateInfo()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
