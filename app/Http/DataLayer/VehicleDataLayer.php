<?php

namespace App\Http\DataLayer;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class VehicleDataLayer
{
    public function getAll()
    {
        return Vehicle::orderBy('id', 'DESC')->get()->isEmpty() ? [] : Vehicle::orderBy('id', 'DESC')->get();
    }

    public function getById($id)
    {
        return $id === null ? null : Vehicle::findOrFail($id);
    }

    public function insert($request)
    {

        $newMainImageName = null;
        if ($request->hasFile('vehical_image')) {
            $newMainImageName = Str::random(12) . '.' . $request->vehical_image->extension();
            $request->vehical_image->move(public_path('images/vehical_image'), $newMainImageName);
        }

        // for ($i = 1; $i <= 11; $i++) {
        //     $imageKey = "products_other_image_$i";
        //     $imageName = "newOtherImageName$i";

        //     if ($request->hasFile($imageKey)) {
        //         $$imageName = Str::random(12) . '.' . $request->$imageKey->extension();
        //         $request->$imageKey->move(public_path("images/vehical_image/$i"), $$imageName);
        //     }
        // }

        try {
            $dataObj = Vehicle::create([
                'name' => $request->input('name'),
                'category_id' => $request->input('category_id'),
                'vehicle_number' => $request->input('vehicle_number'),
                'model' => $request->input('model'),
                'year' => $request->input('year'),
                'price' => $request->input('price'),
                'main_image' => isset($newMainImageName) ? $newMainImageName : null,
                'other_image_01' => $newOtherImageName1 ?? null,
                'other_image_02' => $newOtherImageName2 ?? null,
                'other_image_03' => $newOtherImageName3 ?? null,
                'other_image_04' => $newOtherImageName4 ?? null,
                'isDisplay' => $request->input('isDisplay') ? 1 : 0,
                'created_by' => Auth::user()->id,
            ]);
            return $dataObj;
        } catch (QueryException $exception) {
            Log::error('Error inserting vehicle: ' . $exception->getMessage());
            return null;
        }
    }

    public function update($request, $id)
    {
        try {
            $dataObj = $this->getById($id);
            $dataObj->name = $request->input('name');
            $dataObj->category_id = $request->input('category_id');
            $dataObj->vehicle_number = $request->input('vehicle_number');
            $dataObj->model = $request->input('model');
            $dataObj->year = $request->input('year');
            $dataObj->price = $request->input('price');
            $dataObj->main_image = $request->input('main_image');
            $dataObj->other_image_01 = $request->input('other_image_01');
            $dataObj->other_image_02 = $request->input('other_image_02');
            $dataObj->other_image_03 = $request->input('other_image_03');
            $dataObj->other_image_04 = $request->input('other_image_04');
            $dataObj->isDisplay = $request->input('isDisplay') ? 1 : 0;

            $oldMainImageName = $dataObj->main_image;
            $oldMainImagePath = public_path("images/vehical_image/$oldMainImageName");

            if ($request->hasFile('vehical_image')) {
                $newMainImageName = Str::random(12) . '.' . $request->vehical_image->extension();
                $request->vehical_image->move(public_path('images/vehical_image'), $newMainImageName);
                $dataObj->main_image = $newMainImageName;

                if (file_exists($oldMainImagePath)) {
                    try {
                        unlink($oldMainImagePath);
                    } catch (\ErrorException $e) {
                        return response()->json(['error' => 'Unable to delete file.'], 422);
                    }
                }
            }

            $dataObj->updated_by = Auth::user()->id;
            $dataObj->save();

            return $dataObj;
        } catch (QueryException $exception) {
            Log::error('Error updating vehicle: ' . $exception->getMessage());
            return null;
        }
    }

    public function delete($id)
    {
        try {
            $dataObjUpd = $this->getById($id);
            $dataObjUpd->updated_by = Auth::user()->id;
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
        $query = Vehicle::withTrashed()->orderBy('id', 'DESC');
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
            $data = Vehicle::withTrashed()->max('id');
            return $data ?? 0;
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }
}
