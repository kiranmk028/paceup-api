<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PListController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FolderSpaceController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\SpaceFolderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/me', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('workspaces', WorkspaceController::class);

    Route::apiResource('workspaces/{workspace}/spaces', SpaceController::class);
    Route::prefix('workspaces/{workspace}/spaces/{space}/folders')->controller(SpaceFolderController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('{folder}', 'show');
        Route::put('{folder}', 'update');
        Route::delete('{folder}', 'destroy');
    });

    Route::apiResource('workspaces/{workspace}/folders', FolderController::class);
    Route::prefix('workspaces/{workspace}/folders/{folder}/spaces')->controller(FolderSpaceController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('{space}', 'show');
        Route::put('{space}', 'update');
        Route::delete('{space}', 'destroy');
    });

    Route::apiResource('workspaces/{workspace}/p_lists', PListController::class);

    Route::apiResource('workspace/{workspace}/tasks', TaskController::class);
});

// Route::fallback(function() {
//     return 'lollad';
// });
