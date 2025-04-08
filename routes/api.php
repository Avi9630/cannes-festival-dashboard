<?php

use App\Http\Controllers\IpApplicationFormController;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::group(['middleware' => ['auth:sanctum']], function () {
Route::post('title_of_film',    [IpApplicationFormController::class, 'titleOfFilm']);
// Route::post('destoy_token',     [AuthController::class, 'destroyToken']);
// Route::resource('tasks',        TasksController::class);
// });

Route::get('test', [ApiController::class, 'Test'])->name('test');
Route::post('download-zip-folder',   [ApiController::class, 'downloadFolder'])->name('download-zip-folder');

Route::get('get-all-pdf-ip',        [ApiController::class, 'ipPdfGenerator'])->name('get-all-pdf-ip');
Route::get('get-all-pdf-dd',        [ApiController::class, 'ddPdfGenerator'])->name('get-all-pdf-dd');
Route::get('get-all-pdf-ott',       [ApiController::class, 'ottPdfGenerator'])->name('get-all-pdf-ott');
