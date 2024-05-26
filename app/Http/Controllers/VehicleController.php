<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\VehicleDataLayer;
use App\Http\DataLayer\CategoryDataLayer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class VehicleController extends Controller
{
    protected $vehicleDL;
    protected $categoryDL;

    public function __construct(VehicleDataLayer $vehicleDL, CategoryDataLayer $categoryDL)
    {
        $this->vehicleDL = $vehicleDL;
        $this->categoryDL = $categoryDL;
    }

    public function index()
    {
        $vehicleObj = $this->vehicleDL->getAll();
        $constraints = [
            'name' => null,
            'isDisplay' => "",
        ];
        $params = [
            'dataObj' => $vehicleObj,
            'searchingVals' => $constraints,
        ];
        return view('pages.vehical.index')->with($params);
    }

    public function indexAPI()
    {
        return $this->vehicleDL->getAll();
    }

    public function search(Request $request)
    {
        $constraints = [
            'id' => $request['search_id'],
            'name' => $request['search_name'],
            'isDisplay' => $request['search_display'],
        ];

        $vehicleObj = $this->vehicleDL->doSearchingQuery($constraints);
        $params = [
            'dataObj' => $vehicleObj,
            'searchingVals' => $constraints,
        ];
        return view('pages.vehical.index')->with($params);
    }

    public function create()
    {
        $vehicleObj = null;
        $lastID = $this->vehicleDL->getLastId();
        $categoryObj = $this->categoryDL->getAll();
        $params = [
            'vehicleObj'  => $vehicleObj,
            'lastID' => $lastID,
            'categoryObj'   =>  $categoryObj,
        ];
        return view('pages.vehical.create')->with($params);
    }

    public function store(Request $request)
    {
        $this->validationRules($request);
        $vehicleObj = $this->vehicleDL->insert($request);
        return redirect()->route('vehical.index')->with('success', trans('general.form.flash.created', ['name' => 'vehicle']));
    }

    public function show($id)
    {
        $vehicleObj = $this->vehicleDL->getById($id);
        $categoryObj = $this->categoryDL->getAll();
        $params = [
            'dataObj' => $vehicleObj,
            'categoryObj'   =>  $categoryObj,
        ];
        return view('pages.vehical.delete')->with($params);
    }

    public function getByID($id)
    {
        return $this->vehicleDL->getById($id);
    }

    public function edit($id)
    {
        $vehicleObj = $this->vehicleDL->getById($id);
        $categoryObj = $this->categoryDL->getAll();
        $params = [
            'dataObj' => $vehicleObj,
            'categoryObj'   =>  $categoryObj,
            'vehicleObj'  => $vehicleObj,
        ];
        return view('pages.vehical.edit')->with($params);
    }

    public function update(Request $request, $id)
    {
        $this->validationRules($request, $id);
        $vehicleObj = $this->vehicleDL->update($request, $id);
        return redirect()->route('vehical.index')->with('success', trans('general.form.flash.updated', ['name' => 'vehicle']));
    }

    public function destroy($id)
    {
        $vehicleObj = $this->vehicleDL->delete($id);
        return redirect()->route('vehical.index')->with('success', trans('general.form.flash.deleted', ['name' => $vehicleObj->name]));
    }

    protected function validationRules(Request $request, $id = null)
    {
        $rules = [
            'name' => 'required',
            'vehicle_number' => 'required',
            'model' => 'required',
            'year' => 'required',
        ];

        $messages = [
            'name.required' => 'Vehicle Name is required',
            'vehicle_number.required' => 'Vehicle Number is required',
            'model.required' => 'Vehicle Model is required',
            'year.required' => 'Vehicle Year is required',
        ];

        $request->validate($rules, $messages);
    }
}
