<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Todos

Route::group(['prefix' => 'v1/todos', 'as' => 'todo.'], function () {
    Route::get('/', [TodoController::class, 'index'])->name('show');
    Route::post('/', [TodoController::class, 'store'])->name('create');
    Route::delete('/clear-all-completed', [TodoController::class, 'clearAllCompleted'])->name('clear.all_completed');
    Route::prefix('/{todo}')->group(function () {
        Route::get('/', [TodoController::class, 'show']);
        Route::put('/', [TodoController::class, 'update'])->name('update');
        Route::delete('/', [TodoController::class, 'destroy']);
        Route::post('/restore', [TodoController::class, 'restore'])->withTrashed();
        Route::delete('/force-delete', [TodoController::class, 'forceDelete']);
        Route::put('/is-complete', [TodoController::class, 'updateIsComplete'])->name('update.is_complete');

    });
});
