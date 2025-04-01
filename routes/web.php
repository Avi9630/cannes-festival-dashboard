<?php

use App\Http\Controllers\BestBookCinemaController;
use App\Http\Controllers\BestFilmCriticController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CmotController;
use App\Http\Controllers\FestivalEntryController;
use App\Http\Controllers\NfaController;
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
    Route::get('cmot-dashboard',    [CmotController::class, 'dashboard']);
    Route::get('level-dashboard',   [CmotController::class, 'lavelDashboard']);
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

    Route::get('nfa-feature',       [NfaController::class, 'nfaFeature'])->name('nfa-feature');
    Route::get('nfa-non-feature',   [NfaController::class, 'nfaNonFeature'])->name('nfa-non-feature');
    Route::get('best-book-cinema',  [BestBookCinemaController::class, 'index'])->name('best-book-cinema');
    Route::get('best-film-critic',  [BestFilmCriticController::class, 'index'])->name('best-film-critic');

    Route::get('cannes-entries-list',           [FestivalEntryController::class, 'index'])->name('cannes-entries-list');
    Route::get('cannes-entries-view/{id}',      [FestivalEntryController::class, 'view'])->name('cannes-entries.view');
    Route::get('cannes-entries-delete/{id}',    [FestivalEntryController::class, 'destroy'])->name('cannes-entries.delete');
    Route::get('cannes-entries-delete/{id}',    [FestivalEntryController::class, 'destroy'])->name('cannes-entries.delete');
    Route::get('score-by/{id}',                 [FestivalEntryController::class, 'score']); //->name('score.by');
    Route::post('score-by/{id}',                [FestivalEntryController::class, 'feedback']); //->name('score.by');

    Route::controller(NfaController::class)->group(function () {

        //FEATURE
        Route::get('nfa-feature-search',    'featureSearch')->name('nfa-feature-search');
        Route::get('export-search',         'featureExportSearch')->name('export.search');
        Route::get('nfa-feature-export',    'featureExportAll')->name('nfa-feature-export');
        Route::get('nfa-feature/pdf/{id}',  'featurePdf')->name('nfa-feature-pdf');
        Route::get('nfa-feature/zip/{id}',  'nfaFeatureDocsAsZip')->name('nfa-feature-zip');

        //NON-FEATURE
        Route::get('nfa-non-feature-search',    'nonFeatureSearch')->name('nfa-non-feature-search');
        Route::get('non-feature-export-search', 'nonFeatureExportSearch')->name('non-feature-export-search');
        Route::get('nfa-non-feature-export',    'nonFeatureExportAll')->name('nfa-non-feature-export');
        Route::get('nfa-non-feature/pdf/{id}',  'nonFeaturePdf')->name('nfa-non-feature-pdf');
        Route::get('nfa-non-feature/zip/{id}',  'nfaNonFeatureDocsAsZip')->name('nfa-non-feature-zip');
    });

    //Best-Book-Cinema
    Route::controller(BestBookCinemaController::class)->group(function () {
        //FEATURE
        Route::get('best-book-cinema-search',           'bestBookSearch')->name('best-book-cinema-search');
        Route::get('best-book-cinema-export-search',    'bestBookExport')->name('best-book-cinema-export-search');
        Route::get('best-book-cinema-export-all',       'bestBookExportAll')->name('best-book-cinema-export-all');

        Route::get('ip/zip/{id}',           'downloadDocumentsAsZip')->name('ip.zip');
        Route::get('ip/pdf/{id}',            'ippdf')->name('ip.pdf');
    });

    //Best-Film-Critic
    Route::controller(BestFilmCriticController::class)->group(function () {
        //FEATURE
        Route::get('best-film-critic-search',           'bestFilmCriticSearch')->name('best-film-critic-search');
        Route::get('best-film-critic-export-search',    'bestFilmCriticExport')->name('best-film-critic-export-search');
        Route::get('best-film-critic-export-all',       'bestFilmCriticExportAll')->name('best-film-critic-export-all');

        Route::get('ip/zip/{id}',           'downloadDocumentsAsZip')->name('ip.zip');
        Route::get('ip/pdf/{id}',            'ippdf')->name('ip.pdf');
    });

    Route::get('permission_search',     [PermissionController::class, 'search'])->name('permissions.search');
});

Route::fallback(function () {
    return abort(401, "User can't perform this action.");
});
