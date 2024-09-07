<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ErrorController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

define('COUNT', 20);

Route::group([
    //    'namespace' => 'Admin',
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'guest:admin']
], function () {
    Route::get('/login', [AuthController::class, 'get_admin_login'])->name('get.admin.login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login');

    //reset password
    Route::post('mail-reset-password', [AuthController::class, 'mail_reset_password'])->name('admin.mail.reset.password');
    Route::get('reset-password/{email}', [AuthController::class, 'reset_password_page'])->name('admin.reset.password.page');
    Route::post('reset-password-store/{email}', [AuthController::class, 'reset_password_store'])->name('admin.reset.password.store');
});


Route::group([
    //    'namespace' => 'Admin',
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:admin']
], function () {
    //Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');


    //profile
    Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::match(['post', 'put', 'patch'], 'profile/update/{id}', [ProfileController::class, 'update_profile'])->name('admin.update.profile');
    Route::match(['post', 'put', 'patch'], 'update-password/{id}', [ProfileController::class, 'change_password'])->name('admin.change.password');


    //
    Route::resource('roles', RoleController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('users', UserController::class);

    //logout
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::fallback([ErrorController::class, 'error'])->name('admin.error');
});
