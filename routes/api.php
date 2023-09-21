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
Route::prefix('v1/todos')->group(function () {
    Route::get('/', [TodoController::class, 'index'])->name('todo.show');
    Route::post('/', [TodoController::class, 'store'])->name('todo.create');
    Route::prefix('/{todo}')->group(function () {
        Route::get('/', [TodoController::class, 'show']);
        Route::put('/', [TodoController::class, 'update'])->name('todo.update');
        Route::delete('/', [TodoController::class, 'destroy']);
        Route::post('/restore', [TodoController::class, 'restore'])->withTrashed();
        Route::delete('/force-delete', [TodoController::class, 'forceDelete']);
        Route::put('/is-active', [TodoController::class, 'isActive']);
        Route::put('/is-complete', [TodoController::class, 'isComplete']);
    });
});
