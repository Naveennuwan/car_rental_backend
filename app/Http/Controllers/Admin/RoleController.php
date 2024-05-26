<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\DataLayer\PermissionDataLayer;
use App\Http\DataLayer\RoleDataLayer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;
use App\Exports\ExportCsv;

class RoleController extends Controller
{
    protected $roleDL;
    protected $permissionDL;
    public function __construct(RoleDataLayer $roleDL, PermissionDataLayer $permissionDL)
    {
        $this->roleDL   = $roleDL;
        $this->permissionDL   = $permissionDL;
        $this->middleware('permission:role-access');
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['show', 'delete']]);
    }
    public function index()
    {
        $dataObj = $this->roleDL->getAll();
        $params = [
            'dataObj'   =>  $dataObj,
            'searchingVals' => null,
        ];
        return view('admin.roles.index')->with($params);
    }

    public function search(Request $request)
    {
        $constraints = [
            'name' => $request['search_name'],
            // 'name_jp' => $request['search_name_jp'],
        ];

        $dataObj = $this->roleDL->doSearchingQuery($constraints);
        $params = [
            'dataObj'   =>  $dataObj,
            'searchingVals' => $constraints,
        ];
        return view('admin.roles.index')->with($params);
    }

    public function export(Request $request)
    {
        $export_path = public_path("csv_export");
        $fileName = "Role_Data_" . date('Ymd_His') . ".xlsx";

        $selected_ids = $request->check_id;

        if ($selected_ids === null || empty($selected_ids)) {
            return redirect()->back()->with('error', 'No records selected for export.');
        }

        if (!is_dir($export_path)) {
            mkdir($export_path, 0777, true);
        }

        $roleListExport = new ExportCsv($selected_ids);
        $filePath = $export_path . DIRECTORY_SEPARATOR . $fileName;

        $roleListExport->exportRole($filePath);

        return Response::download($filePath)->deleteFileAfterSend(true);
    }

    public function create()
    {
        try {
            $result = $this->roleDL->getRoleWithPermission();
            $params = [
                'roleObj'   =>  $result['roleObj'],
                'permissions_array'   =>  $result['permissions_array'],
                'existing_permissions_array'   =>  $result['existing_permissions_array'],
            ];
            return view('admin.roles.create')->with($params);
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
            $dataObj = $this->roleDL->insert($request);
            return redirect()->route('admin.roles.index')->with('success', trans('general.form.flash.created', ['name' => $dataObj->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function edit($id)
    {
        try {
            $dataObj = $this->roleDL->getById($id);
            $result = $this->roleDL->getRoleWithPermission($id);
            $params = [
                'dataObj'  => $dataObj,
                'roleObj'   =>  $result['roleObj'],
                'permissions_array'   =>  $result['permissions_array'],
                'existing_permissions_array'   =>  $result['existing_permissions_array'],
            ];
            return view('admin.roles.edit')->with($params);
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
            $dataObj = $this->roleDL->update($request, $id);
            return redirect()->route('admin.roles.index')->with('success', trans('general.form.flash.updated', ['name' => $dataObj->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function show($id)
    {
        try {
            $dataObj = $this->roleDL->getById($id);
            $result = $this->roleDL->getRoleWithPermission($id);
            $params = [
                'dataObj' => $dataObj,
                'roleObj'   =>  $result['roleObj'],
                'permissions_array'   =>  $result['permissions_array'],
                'existing_permissions_array'   =>  $result['existing_permissions_array'],
            ];
            return view('admin.roles.delete')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function destroy($id)
    {
        try {
            $dataObj = $this->roleDL->delete($id);
            return redirect()->route('admin.roles.index')->with('success', trans('general.form.flash.deleted', ['name' => $dataObj->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    protected function validationRules(Request $request, $id = null)
    {
        $rules = [
            'roles_name' => 'required',
            // 'roles_name_jp' => 'required',
            'permission_ids' => 'required|array|min:1', // Ensure at least one item is selected
        ];

        $messages = [
            'roles_name' => [
                'required' => '「名前」は必須です。', //The name field is required.
            ],
            // 'roles_name_jp' => [
                // 'required' => '「名前-日本語」は必須です。', //The name-jp field is required.
            // ],
            'permission_ids' => [
                'required' => 'Ensure at least one item is selected', //The name-jp field is required.
            ],
        ];

        if ($id) {
            $rules['roles_name'] .= '|unique:roles,name,' . $id;
        } else {
            $rules['roles_name'] .= '|unique:roles,name';
        }
        $request->validate($rules, $messages);
    }
}
