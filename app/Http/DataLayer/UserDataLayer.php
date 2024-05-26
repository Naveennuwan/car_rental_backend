<?php

namespace App\Http\DataLayer;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserDataLayer
{

    public function getAll()
    {
        try {
            $dataObj = User::all();
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
            $dataObj = User::withTrashed()->find($id);
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
            $dataObj = User::create([
                'name' => trim($request->input('users_name')),
                'first_name' => trim($request->input('users_first_name')),
                'last_name' => trim($request->input('users_last_name')),
                'user_type' => "user",
                'email' => trim($request->input('users_email')),
                'password' => bcrypt($request->input('users_password')),
                'created_by' => Auth::user()->id,
            ]);

            $dataObj->roles()->attach($request->users_role_id);
            $dataObj->permissions()->attach($request->users_permission_id);
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
            $dataObj->name = trim($request->input('users_name'));
            $dataObj->first_name = trim($request->input('users_first_name'));
            $dataObj->last_name = trim($request->input('users_last_name'));
            $dataObj->email = trim($request->input('users_email'));
            $dataObj->password =  bcrypt($request->input('users_password'));
            $dataObj->updated_by =  Auth::user()->id;
            $dataObj->save();
            $rolesObj = $dataObj->roles;
            foreach ($rolesObj as $key => $value) {
                $dataObj->removeRole($value);
            }
            $dataObj->roles()->attach($request->users_role_id);
            $permissionsObj = $dataObj->permissions;
            foreach ($permissionsObj as $key => $value) {
                $dataObj->revokePermissionTo($value);
            }
            $dataObj->permissions()->attach($request->users_permission_id);
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
        $query = User::withTrashed()->orderBy('id', 'DESC');
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
            case 'first_name':
                $query->where($field, 'like', '%' . trim($constraint) . '%');
                break;
            case 'email':
                $query->where($field, 'like', '%' . trim($constraint) . '%');
                break;
                // case 'role_id':
                //     $query->where($field, $constraint);
                //     break;
        }
    }
}
