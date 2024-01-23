<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin.auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.main');
})->middleware(['auth', 'verified', 'disable-back'])->name('dashboard');

Route::middleware(['auth', 'disable-back'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Client
    Route::get('/client', [ClientController::class, 'index'])->name('client')->middleware('permission:view.client');
    Route::get('/client/add', [ClientController::class, 'create'])->name('create.client')->middleware('permission:create.client');
    Route::post('/client/add', [ClientController::class, 'store']);
    Route::get('/client/edit/{id}', [ClientController::class, 'edit'])->name('edit.client')->middleware('permission:edit.client');
    Route::post('/client/edit/{id}', [ClientController::class, 'update']);
    Route::get('/client/show/{id}', [ClientController::class, 'show'])->name('view.client')->middleware('permission:view.client');
    Route::get('/client/delete', [ClientController::class, 'destroy'])->name('delete.client')->middleware('permission:delete.client');

    //check client_id
    Route::post('/check-clientid-exists', [ClientController::class, 'checkclient_idExists']);

    //check mobilenumber
    Route::post('/check-mobile-exists', [ClientController::class, 'checkMobileExists']);
    Route::post('/edit-check-mobile-exists', [ClientController::class, 'editcheckMobileExists']);

    //check emailaddress
    Route::post('/check-email-exists', [ClientController::class, 'checkemailExists']);
    Route::post('/edit-check-email-exists', [ClientController::class, 'editcheckemailExists']);

    //user
    Route::get('/user', [UserController::class, 'index'])->name('user')->middleware('permission:view.user');
    Route::get('/user/add', [UserController::class, 'create'])->name('create.user')->middleware('permission:create.user');
    Route::post('/user/add', [UserController::class, 'store']);
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('edit.user')->middleware('permission:edit.user');
    Route::post('/user/edit/{id}', [UserController::class, 'update']);
    Route::get('/user/show/{id}', [UserController::class, 'show'])->name('view.user')->middleware('permission:view.user');
    Route::get('/user/delete', [UserController::class, 'destroy'])->name('delete.user')->middleware('permission:delete.user');
});

require __DIR__ . '/auth.php';
