<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashBoardController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VehicleController;

// cache clear
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('optimize');
    return '<h1>Cache Cleared</h1>';
});


Route::get('/', [DashBoardController::class, 'index'])->middleware(['auth']);
Route::get('/dashboard', [DashBoardController::class, 'index'])->middleware(['auth']);

Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::post('/roles/search', [RoleController::class, 'search'])->name('roles.search');
    Route::post('/roles/export', [RoleController::class, 'export'])->name('roles.export');

    Route::resource('/permissions', PermissionController::class);
    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');

    Route::post('/permissions/search', [PermissionController::class, 'search'])->name('permissions.search');
    Route::post('/permissions/export', [PermissionController::class, 'export'])->name('permissions.export');

    Route::resource('/users', UserController::class);
    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');
    Route::post('/update-user-status/{id}', [UserController::class, 'updateStatus'])->name('update.user.status');

    Route::post('/users/search-users', [UserController::class, 'searchUsers'])->name('users.searchUsers');
    Route::post('/users/export-users', [UserController::class, 'exportUsers'])->name('users.exportUsers');


    
    
});



Route::middleware(['auth'])->group(function () {
    Route::resource('/category', CategoryController::class);
    Route::match(['get', 'post'], '/search-category', [CategoryController::class, 'search'])->name('category.search');
    Route::post('/export-category', [CategoryController::class, 'export'])->name('category.export');


    Route::resource('/vehical', VehicleController::class);
    Route::match(['get', 'post'], '/search-vehical', [VehicleController::class, 'search'])->name('vehical.search');
    Route::post('/export-vehical', [VehicleController::class, 'export'])->name('vehical.export');
});

Route::get('/run-migrations', function () {
    return Artisan::call('migrate', ["--force" => true]);
});

require __DIR__ . '/auth.php';
