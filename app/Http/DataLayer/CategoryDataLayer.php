<?php

namespace App\Http\DataLayer;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;


class CategoryDataLayer
{
    public function getAll()
    {
        return Category::orderBy('id', 'DESC')->get()->isEmpty() ? [] : Category::orderBy('id', 'DESC')->get();
    }

    public function getById($id)
    {
        return $id === null ? null : Category::findOrFail($id);
    }

    public function insert($request)
    {
        try {
            $dataObj = Category::create([
                'name' => $request->input('categories_name'),
                'isDisplay' => $request->input('categories_isDisplay') ? 1 : 0,
                'created_by' => Auth::user()->id,
            ]);
            return $dataObj;
        } catch (QueryException $exception) {
            Log::error('Error inserting category: ' . $exception->getMessage());
            return null;
        }
    }

    public function update($request, $id)
    {
        try {
            $dataObj = $this->getById($id);
            $dataObj->name = $request->input('categories_name');
            $dataObj->isDisplay = $request->input('categories_isDisplay') ? 1 : 0;

            $dataObj->updated_by =  Auth::user()->id;
            $dataObj->save();

            return $dataObj;
        }  catch (QueryException $exception) {
            Log::error('Error updating category: ' . $exception->getMessage());
            return null;
        }
    }

    public function delete($id)
    {
        try {
            $dataObjUpd = $this->getById($id);
            $dataObjUpd->updated_by =  Auth::user()->id;
            $dataObjUpd->save();

            $dataObjDel = $this->getById($id);
            $dataObjDel->delete();

            return $dataObjDel;
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function doSearchingQuery($constraints)
    {
        $query = Category::withTrashed()->orderBy('id', 'DESC');
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
            case 'id':
                $query->where('id', '=', trim($constraint));
                break;
            case 'name':
                $query->where($field, 'like', '%' . trim($constraint) . '%');
                break;
            case 'isDisplay':
                $query->where($field, '=', trim($constraint));
                break;
        }
    }

    public function getLastId()
    {
        try {
            $data = Category::withTrashed()->max('id');
            return $data ?? 0;
        } catch (ModelNotFoundException $ex) {

            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }
}
