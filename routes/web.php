<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Frontend\AuthenticationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ManagementController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController as BackendHomeController;

Auth::routes();

// Frontend Routes start

//home page start
Route::get('/',[HomeController::class,'index'])->name('frontend.home');
//home page end
//authentication routes start
Route::get('auth/login',[AuthenticationController::class,'login'])->name('auth.login');
Route::post('auth/login',[AuthenticationController::class,'login_post'])->name('auth.login');
Route::get('auth/register',[AuthenticationController::class,'register'])->name('auth.register');
Route::post('auth/register',[AuthenticationController::class,'register_post'])->name('auth.register');

//authentication routes end
//frontend Routes end


// Backend Routes start

//dashboard home route start
Route::get('/home', [BackendHomeController::class, 'index'])->name('dashboard.home');
//dashboard home route end

//dashboard management route start
Route::middleware(['role_check'])->group(function(){
    Route::get('/management', [ManagementController::class, 'index'])->name('management.register');
    Route::post('/management/store', [ManagementController::class, 'store'])->name('management.register.store');
    Route::post('/management/manager/down/{id}', [ManagementController::class, 'manager_down'])->name('management.manager.down');
    Route::get('/management/manager/delete/{id}', [ManagementController::class, 'manager_delete'])->name('management.manager.delete');

    // assign existing role
    Route::get('/management/role', [ManagementController::class, 'assign_existing_role'])->name('management.assign.existing.role');
    Route::post('/management/role/store', [ManagementController::class, 'assign_existing_role_store'])->name('management.assign.existing.role.store');
    Route::post('/management/role/blogger/down/{id}', [ManagementController::class, 'assign_existing_role_blogger_down'])->name('management.assign.existing.role.blogger.down');
});
//dashboard management route end

//Account Settings Routes start
Route::get('/home/account/settings',[AccountSettingsController::class,'index'])->name('home.account.settings');
Route::post('name/update',[AccountSettingsController::class,'name_update'])->name('name.update');
Route::post('email/update',[AccountSettingsController::class,'email_update'])->name('email.update');
Route::post('dashboard/password/update',[AccountSettingsController::class,'password_update'])->name('dashboard.password.update');
Route::post('dashboard/image/update',[AccountSettingsController::class,'image_update'])->name('dashboard.image.update');
//Account Settings Routes end

// Category Routes start
Route::get('/category',[CategoryController::class,'index'])->name('category.index');
Route::post('/category/store',[CategoryController::class,'store'])->name('category.store');
Route::post('/category/status/{slug}',[CategoryController::class,'status'])->name('category.status');
Route::get('/category/edit/{slug}',[CategoryController::class,'edit'])->name('category.edit');
Route::post('/category/update/{slug}',[CategoryController::class,'update'])->name('category.update');
Route::get('/category/delete/{slug}',[CategoryController::class,'delete'])->name('category.delete');
// Category Routes end

// Backend Routes end
