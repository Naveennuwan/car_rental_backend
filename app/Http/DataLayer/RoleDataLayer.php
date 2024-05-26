<?php

namespace App\Http\DataLayer;

use App\Models\CustomPermission;
use App\Models\ModelHasPermission;
use App\Models\Resource;
use App\Models\RoleHasPermission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RoleDataLayer
{
    public function getAll()
    {
        try {
            $dataObj = Role::all();
            return $dataObj;
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function getById($id)
    {
        try {
            $dataObj = Role::findOrFail($id);
            return $dataObj;
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function insert($request)
    {
        try {
            $dataObj = Role::create([
                'name' => trim($request->input('roles_name')),
                'guard_name' => "web",
                'created_by' => Auth::user()->id,
            ]);
            $dataObj->givePermissionTo($request->permission_ids);
            return $dataObj;
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function update($request, $id)
    {
        try {
            $dataObj = $this->getById($id);
            $dataObj->name = trim($request->input('roles_name'));
            $dataObj->updated_by =  Auth::user()->id;
            $dataObj->save();
            $this->deleteRolePermissions($id);
            $dataObj->givePermissionTo($request->permission_ids);

            return $dataObj;
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function delete($id)
    {
        try {
            $dataObj = $this->getById($id);
            $dataObj->delete();

            return $dataObj;
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function doSearchingQuery($constraints)
    {
        $query = Role::orderBy('id', 'DESC');
        foreach ($constraints as $field => $constraint) {
            if ($constraint !== null) {
                $this->applyConstraint($query, $field, $constraint);
            }
        }
        return $query->get();
    }

    public function applyConstraint($query, $field, $constraint)
    {
        switch ($field) {
            case 'name':
                $query->where($field, 'like', '%' . trim($constraint) . '%');
                break;
        }
    }

    public function getRoleWithPermission($role_id = null)
    {
        $roleObj = null;
        $permissions_array = [];
        $existing_permissions_array = [];
        $resourcesObj = Resource::all();
        foreach ($resourcesObj as $resource) {
            $permissionObj = CustomPermission::where('resource_id', '=', $resource->id)->get();
            foreach ($permissionObj as $permission) {
                $permissions_array[$resource->name][$permission->id] = $permission->name;
            }
        }

        if ($role_id) {
            $roleObj = Role::find($role_id);
            $existing_permissions_array = RoleHasPermission::where('role_id', '=', $role_id)
                ->pluck('permission_id')
                ->toArray();
        }

        return [
            'roleObj' => $roleObj,
            'permissions_array' => $permissions_array,
            'existing_permissions_array' => $existing_permissions_array,
        ];
    }

    public function deleteRolePermissions($role_id)
    {
        return RoleHasPermission::where('role_id', $role_id)->delete();
    }
}
