<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormDataController;

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


Route::middleware('scope.user')->group(function () {
    Route::get('/protected', function () {
        return response()->json(['message' => 'Access granted']);
    });
    Route::get('/tag', [TagController::class, 'index'])->name('tag.all');
    Route::get('/forms/{id}', [FormController::class, 'show'])->name('forms.show');
    Route::get('/forms', [FormController::class, 'index'])->name('forms.create');
    Route::put('/forms/update/{id}', [FormController::class, 'update'])->name('forms.update');
    Route::get('/forms/view/{id}/{entity}/{entity_id}', [FormController::class, 'view'])->name('forms.update');
    Route::post('/forms/create', [FormController::class, 'create'])->name('forms.create');
    //Route::post('/form-data/{id}/data', [FormController::class, 'storeData'])->name('formdata.store');
    Route::post('/form-data/create', [FormDataController::class, 'store'])->name('formdata.store');
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
