<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\CategoryDataLayer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Exports\ExportCsv;

class CategoryController extends Controller
{
    protected $categoryDL;
    public function __construct(CategoryDataLayer $categoryDL)
    {
        $this->categoryDL = $categoryDL;
    }

    public function index()
    {
        $categoryObj = $this->categoryDL->getAll();
        $constraints = [
            'name' => null,
            'isDisplay' => "",
        ];
        $params = [
            'categoryObj'   =>  $categoryObj,
            'searchingVals' => $constraints,
        ];
        return view('pages.category.index')->with($params);
    }

    public function search(Request $request)
    {
        $constraints = [
            'id' => $request['search_id'],
            'name' => $request['search_name'],
            'isDisplay' => $request['search_display'],
        ];

        $categoryObj = $this->categoryDL->doSearchingQuery($constraints);
        $params = [
            'categoryObj'   =>  $categoryObj,
            'searchingVals' => $constraints,
        ];
        return view('pages.category.index')->with($params);
    }

    public function export(Request $request)
    {
        $export_path = public_path("csv_export");
        $fileName = "Category_" . date('Ymd_His') . ".xlsx";

        $selected_ids = $request->check_id;

        if ($selected_ids === null || empty($selected_ids)) {
            return redirect()->back()->with('error', 'No records selected for export.');
        }

        if (!is_dir($export_path)) {
            mkdir($export_path, 0777, true);
        }

        $roleListExport = new ExportCsv($selected_ids);
        $filePath = $export_path . DIRECTORY_SEPARATOR . $fileName;

        $roleListExport->exportCategory($filePath);

        return Response::download($filePath)->deleteFileAfterSend(true);
    }

    public function create()
    {
        try {
            $lastID = $this->categoryDL->getLastId();
            $params = [
                'lastID'   => $lastID
            ];
            return view('pages.category.create')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validationRules($request);
            $categoryObj = $this->categoryDL->insert($request); 
            return redirect()->route('category.index')->with('success', trans('general.form.flash.created', ['name' => $categoryObj->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function show($id)
    {
        try {
            $categoryObj = $this->categoryDL->getById($id);
            $params = [
                'categoryObj' => $categoryObj,
            ];
            return view('pages.category.delete')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function edit($id)
    {
        try {
            $categoryObj = $this->categoryDL->getById($id);
            $params = [
                'categoryObj'  => $categoryObj,
            ];
            return view('pages.category.edit')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validationRules($request, $id);
            $categoryObj = $this->categoryDL->update($request, $id);
            return redirect()->route('category.index')->with('success', trans('general.form.flash.updated', ['name' => $categoryObj->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function destroy($id)
    {
        try {
            $categoryObj = $this->categoryDL->delete($id);
            return redirect()->route('category.index')->with('success', trans('general.form.flash.deleted', ['name' => $categoryObj->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    protected function validationRules(Request $request, $id = null)
    {

        $rules = [
            'categories_name' => 'required',
        ];

        $messages = [
            'categories_name' => [
                'required' => 'Category Name is empty',
            ],
        ];

        $request->validate($rules, $messages);
    }
}
