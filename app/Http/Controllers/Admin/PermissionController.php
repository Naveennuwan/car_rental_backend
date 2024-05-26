<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\DataLayer\PermissionDataLayer;
use App\Http\DataLayer\ResourceDataLayer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Response;
use App\Exports\ExportCsv;

class PermissionController extends Controller
{
    protected $permissionDL;
    protected $resourceDL;

    public function __construct(PermissionDataLayer $permissionDL, ResourceDataLayer $resourceDL)
    {
        $this->permissionDL   = $permissionDL;
        $this->resourceDL   = $resourceDL;
        $this->middleware('permission:permission-access');
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['show', 'delete']]);
    }

    public function index()
    {
        $dataObj = $this->permissionDL->getAll();
        $dataObjResource = $this->resourceDL->getAll();
        $params = [
            'dataObj'   =>  $dataObj,
            'dataObjResource'   =>  $dataObjResource,
            'searchingVals' => null,
        ];
        return view('admin.permissions.index')->with($params);
    }

    public function search(Request $request)
    {
        $constraints = [
            'name' => $request['search_name'],
            'name_jp' => $request['search_name_jp'],
            'resource_id' => $request['search_resource_id'],
        ];

        $dataObj = $this->permissionDL->doSearchingQuery($constraints);
        $dataObjResource = $this->resourceDL->getAll();
        $params = [
            'dataObj'   =>  $dataObj,
            'dataObjResource'   =>  $dataObjResource,
            'searchingVals' => $constraints,
        ];
        return view('admin.permissions.index')->with($params);
    }

    public function export(Request $request)
    {
        $export_path = public_path("csv_export");
        $fileName = "Permission_" . date('Ymd_His') . ".xlsx";

        $selected_ids = $request->check_id;

        if ($selected_ids === null || empty($selected_ids)) {
            return redirect()->back()->with('error', 'No records selected for export.');
        }

        if (!is_dir($export_path)) {
            mkdir($export_path, 0777, true);
        }

        $roleListExport = new ExportCsv($selected_ids);
        $filePath = $export_path . DIRECTORY_SEPARATOR . $fileName;

        $roleListExport->exportPermission($filePath);

        return Response::download($filePath)->deleteFileAfterSend(true);
    }

    public function create()
    {
        try {
            $dataObjResource = $this->resourceDL->getAll();
            $params = [
                'dataObjResource'   =>  $dataObjResource,
            ];
            return view('admin.permissions.create')->with($params);
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
            $dataObj = $this->permissionDL->insert($request);
            return redirect()->route('admin.permissions.index')->with('success', trans('general.form.flash.created', ['name' => $dataObj->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function show($id)
    {
        try {
            $dataObj = $this->permissionDL->getById($id);
            $dataObjResource = $this->resourceDL->getAll();
            $params = [
                'dataObj' => $dataObj,
                'dataObjResource'   =>  $dataObjResource,
            ];
            return view('admin.permissions.delete')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function edit($id)
    {
        try {
            $dataObj = $this->permissionDL->getById($id);
            $dataObjResource = $this->resourceDL->getAll();
            $params = [
                'dataObj'  => $dataObj,
                'dataObjResource'   =>  $dataObjResource,
            ];
            return view('admin.permissions.edit')->with($params);
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
            $dataObj = $this->permissionDL->update($request, $id);
            return redirect()->route('admin.permissions.index')->with('success', trans('general.form.flash.updated', ['name' => $dataObj->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function destroy($id)
    {
        try {
            $dataObj = $this->permissionDL->delete($id);
            return redirect()->route('admin.permissions.index')->with('success', trans('general.form.flash.deleted', ['name' => $dataObj->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    protected function validationRules(Request $request, $id = null)
    {
        $rules = [
            'permissions_name' => 'required',
            'permissions_name_jp' => 'required',
            'permissions_resource_id' => 'required',
        ];

        $messages = [
            'permissions_name' => [
                'required' => '「名前」は必須です。', //The name field is required.
            ],
            'permissions_name_jp' => [
                'required' => '「名前-日本語」は必須です。', //The name-jp field is required.
            ],
            'permissions_resource_id' => [
                'required' => '「リソース」は必須です。',
            ],
        ];

        if ($id) {
            // If editing, exclude the unique validation for the current user
            $rules['permissions_name'] .= '|unique:permissions,name,' . $id;
        } else {
            // If creating, include the unique validation
            $rules['permissions_name'] .= '|unique:permissions,name';
        }
        $request->validate($rules, $messages);
    }

    // public function assignRole(Request $request, Permission $permission)
    // {
    //     if ($permission->hasRole($request->role)) {
    //         return back()->with('message', 'Role exists.');
    //     }

    //     $permission->assignRole($request->role);
    //     return back()->with('message', 'Role assigned.');
    // }

    // public function removeRole(Permission $permission, Role $role)
    // {
    //     if ($permission->hasRole($role)) {
    //         $permission->removeRole($role);
    //         return back()->with('message', 'Role removed.');
    //     }

    //     return back()->with('message', 'Role not exists.');
    // }
}
