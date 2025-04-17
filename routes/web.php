<?php

use App\Http\Controllers\FestivalEntryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GrandJuryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('login',     'index')->name('login');
        Route::post('login',    'login')->name('login'); //->middleware('throttle:2,1')
    });
});

Route::get('resetPassword',       [AuthController::class, 'resetPwdView'])->name('resetPassword');
Route::post('resetPassword',      [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::get('sendOtp',             [AuthController::class, 'sendOtpView'])->name('sendOtp');
Route::post('sendOtp',            [AuthController::class, 'sendOtp'])->name('sendOtp');
Route::get('verifyOtp',           [AuthController::class, 'verifyOtpView'])->name('verifyOtp');
Route::post('verifyOtp',          [AuthController::class, 'verifyOtp'])->name('verifyOtp');
Route::get('changePassword',      [AuthController::class, 'changePasswordView'])->name('changePassword');
Route::post('changePassword',     [AuthController::class, 'changePassword'])->name('changePassword');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/',                 [WelcomeController::class, 'index']);
    Route::get('home',              [AuthController::class, 'home'])->name('home');
    Route::get('logout',            [AuthController::class, 'logout'])->name('logout');

    Route::resources([
        'roles'             =>  RoleController::class,
        'users'             =>  UserController::class,
        'permissions'       =>  PermissionController::class,
    ]);

    Route::controller(UserController::class)->group(function () {
        Route::get('user-search',       'search')->name('user.search');
    });

    Route::controller(FestivalEntryController::class)->group(function () {
        Route::get('cannes-entries-list',           'index')->name('cannes-entries-list');
        Route::get('cannes-entries-search',         'search')->name('cannes-entries-search');
        Route::get('cannes-entries-view/{id}',      'view')->name('cannes-entries.view');
        Route::get('cannes-entries-delete/{id}',    'destroy')->name('cannes-entries.delete');
        Route::get('cannes-entries-delete/{id}',    'destroy')->name('cannes-entries.delete');
        Route::get('cannes-entries/pdf/{id}',       'cannesPdf')->name('cannes-entries-pdf');
        Route::get('cannes-entries-export',         'exportAll')->name('cannes-entries-export');
        Route::get('cannes-entries-export-search',  'exportSearch')->name('export.cannes-search');
        Route::get('score-by/{id}',                 'score');
        Route::post('score-by/{id}',                'feedback');
        Route::post('assign_to/{id}',               'assignTo');
    });
    
    Route::controller(GrandJuryController::class)->group(function () {
        Route::get('scored-entries',            'scoredEntry')->name('scored-entries');
        Route::get('scored-entries-view/{id}',  'view')->name('scored-entries-view');
        Route::get('cannes-selected-list',      'index')->name('cannes-selected-list');
        Route::get('final-select/{id}',         'finalSelect')->name('final-select');
        Route::post('assign-to-level2/{id}',    'assignTo');
        
        //LEVEL2
        Route::get('cannes-level2-list',        'level2List')->name('cannes-level2-list');
        Route::get('cannes-level2-view/{id}',   'level2view')->name('cannes-level2-view');
        Route::get('score-by-level2/{id}',       'level2score');
        Route::post('score-by-level2/{id}',      'level2feedback');
        
        // Route::get('selected-by-grand/{id}',    'selectedBy')->name('selected-by-grand');
    });
    Route::get('permission_search',     [PermissionController::class, 'search'])->name('permissions.search');
});

Route::fallback(function () {
    return abort(401, "User can't perform this action.");
});
