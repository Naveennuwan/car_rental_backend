<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\DataLayer\UserDataLayer;
use App\Http\DataLayer\RoleDataLayer;
use App\Http\DataLayer\PermissionDataLayer;

use Illuminate\Support\Facades\Response;
use App\Exports\ExportCsv;
use App\Models\User;

class UserController extends Controller
{
    protected $userDL;
    protected $roleDL;
    protected $permissionDL;
    public function __construct(UserDataLayer $userDL, RoleDataLayer $roleDL, PermissionDataLayer $permissionDL)
    {
        $this->userDL   = $userDL;
        $this->roleDL   = $roleDL;
        $this->permissionDL   = $permissionDL;

        $this->middleware('permission:user-access');
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['show', 'delete']]);
    }

    public function index()
    {
        $usersObj = $this->userDL->getAll();
        $params = [
            'users'   =>  $usersObj,
            'searchingVals' => null,
        ];
        return view('admin.users.index')->with($params);
    }

    public function create()
    {
        try {
            $rolesObj = $this->roleDL->getAll();
            $permissionObj = $this->permissionDL->getAll();
            $params = [
                'roles' => $rolesObj,
                'permissions' => $permissionObj,
            ];
            return view('admin.users.create')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function store(Request $request)
    {
        try {
            if($request->users_password != $request->users_password_confirmation){
                return redirect()->route('admin.users.index')->with('success', trans('Password mis-match', ['name' => null]));
            }else{
                $dataObj = $this->userDL->insert($request);
                return redirect()->route('admin.users.index')->with('success', trans('general.form.flash.created', ['name' => $dataObj->name]));
            }
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function edit($id)
    {

        try {
            $userObj = $this->userDL->getById($id);
            $rolesObj = $this->roleDL->getAll();
            $permissionObj = $this->permissionDL->getAll();
            $params = [
                'user'  => $userObj,
                'roles' => $rolesObj,
                'permissions' => $permissionObj,
            ];
            return view('admin.users.edit')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function show($id)
    {
        try {
            $userObj = $this->userDL->getById($id);
            $rolesObj = $this->roleDL->getAll();
            $permissionObj = $this->permissionDL->getAll();

            $params = [
                'user'  => $userObj,
                'roles' => $rolesObj,
                'permissions' => $permissionObj,
            ];
            return view('admin.users.delete')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function getById($id)
    {
        try {
            $userObj = $this->userDL->getById($id);
            return $userObj;
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if($request->users_password != $request->users_password_confirmation){
                return redirect()->route('admin.users.index')->with('success', trans('Password mis-match', ['name' => null]));
            }else{
                $dataObj = $this->userDL->insert($request);
                return redirect()->route('admin.users.index')->with('success', trans('general.form.flash.created', ['name' => $dataObj->name]));
            }
            // $this->validateUser($request, $id);
            // $dataObj = $this->userDL->update($request, $id);
            // return redirect()->route('admin.users.index')->with('success', trans('general.form.flash.updated', ['name' => $dataObj->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function searchUsers(Request $request)
    {
        $constraints = [
            'name' => $request['search_name'],
            'first_name' => $request['search_first_name'],
            'email' => $request['search_email'],
        ];
        $userObj = $this->userDL->doSearchingQuery($constraints);
        $params = [
            'users'   =>  $userObj,
            'searchingVals' => $constraints,
        ];
        return view('admin.users.index')->with($params);
    }

    public function exportUsers(Request $request)
    {
        $export_path = public_path("csv_export");
        $fileName = "User_" . date('Ymd_His') . ".xlsx";

        $selected_ids = $request->check_id;

        if ($selected_ids === null || empty($selected_ids)) {
            return redirect()->back()->with('error', 'No records selected for export.');
        }

        if (!is_dir($export_path)) {
            mkdir($export_path, 0777, true);
        }

        $roleListExport = new ExportCsv($selected_ids);
        $filePath = $export_path . DIRECTORY_SEPARATOR . $fileName;

        $roleListExport->exportUser($filePath);

        return Response::download($filePath)->deleteFileAfterSend(true);
    }

    public function destroy($id)
    {
        try {
            $dataObj = $this->userDL->delete($id);
            return redirect()->route('admin.users.index')->with('success', trans('general.form.flash.deleted', ['name' => $dataObj->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    public function updateStatus($id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        if ($user) {
            if ($user->deleted_at === null) {
                $user->deleted_at = now();
            } else {
                $user->deleted_at = null;
            }
            // Check if there are changes before saving
            if ($user->isDirty()) {
                $user->save();
            }
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['message' => 'User status updated successfully']);
    }

    protected function validateUser(Request $request, $userId = null)
    {
        $rules = [
            'users_name' => 'required',
            'users_first_name' => 'required',
            'users_last_name' => 'required',
            'users_email' => 'required|email',
            'users_password' => 'required',
            'users_password_confirmation' => 'required',
            'users_role_id' => 'required',
        ];

        if ($userId) {
            // If editing, exclude the unique validation for the current user
            $rules['users_email'] .= '|unique:users,email,' . $userId;
        } else {
            // If creating, include the unique validation
            $rules['users_email'] .= '|unique:users,email';
        }
        $request->validate($rules);
    }

    // public function assignRole(Request $request, User $user)
    // {
    //     if ($user->hasRole($request->role)) {
    //         return back()->with('message', 'Role exists.');
    //     }

    //     $user->assignRole($request->role);
    //     return back()->with('message', 'Role assigned.');
    // }

    // public function removeRole(User $user, Role $role)
    // {
    //     if ($user->hasRole($role)) {
    //         $user->removeRole($role);
    //         return back()->with('message', 'Role removed.');
    //     }

    //     return back()->with('message', 'Role not exists.');
    // }

    // public function givePermission(Request $request, User $user)
    // {
    //     if ($user->hasPermissionTo($request->permission)) {
    //         return back()->with('message', 'Permission exists.');
    //     }
    //     $user->givePermissionTo($request->permission);
    //     return back()->with('message', 'Permission added.');
    // }

    // public function revokePermission(User $user, Permission $permission)
    // {
    //     if ($user->hasPermissionTo($permission)) {
    //         $user->revokePermissionTo($permission);
    //         return back()->with('message', 'Permission revoked.');
    //     }
    //     return back()->with('message', 'Permission does not exists.');
    // }
}
