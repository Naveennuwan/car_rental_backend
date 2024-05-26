<?php

namespace App\Http\DataLayer;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\CustomPermission;

class PermissionDataLayer
{
    public function getAll()
    {
        try {
            $dataObj = CustomPermission::all();
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
            $dataObj = CustomPermission::findOrFail($id);
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
            $dataObj = CustomPermission::create([
                'name' => trim($request->input('permissions_name')),
                'name_jp' => trim($request->input('permissions_name_jp')),
                'resource_id' => trim($request->input('permissions_resource_id')),
                'guard_name' => "web",
                'created_by' => Auth::user()->id,
            ]);

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
            $dataObj->name = trim($request->input('permissions_name'));
            $dataObj->name_jp = trim($request->input('permissions_name_jp'));
            $dataObj->resource_id = trim($request->input('permissions_resource_id'));
            $dataObj->updated_by =  Auth::user()->id;
            $dataObj->save();

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
        $query = CustomPermission::orderBy('id', 'DESC');
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

            case 'name_jp':
                $query->where($field, 'like', '%' . trim($constraint) . '%');
                break;

            case 'resource_id':
                $query->where($field, '=', trim($constraint));
                break;
        }
    }
}
