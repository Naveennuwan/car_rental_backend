<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Models\Resource;

class CustomPermission extends SpatiePermission
{
    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }

    public function userCreateInfo()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
