<?php

namespace App\Http\DataLayer;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Resource;

class ResourceDataLayer
{
    public function getAll()
    {
        try {
            $dataObj = Resource::all();
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
            $dataObj = Resource::findOrFail($id);
            return $dataObj;
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }
}
