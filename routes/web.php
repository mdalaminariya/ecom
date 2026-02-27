<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Frontend\AuthenticationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ProductController;
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
    Route::get('/management/role/manager/edit/{id}', [ManagementController::class, 'manager_edit'])->name('management.assign.existing.role.manager.edit');
    Route::post('/management/role/manager/update/{id}', [ManagementController::class, 'manager_update'])->name('management.assign.existing.role.manager.update');
    Route::get('/management/manager/delete/{id}', [ManagementController::class, 'manager_delete'])->name('management.manager.delete');

    // assign existing role
    Route::get('/management/role', [ManagementController::class, 'assign_existing_role'])->name('management.assign.existing.role');
    Route::post('/management/role/store', [ManagementController::class, 'assign_existing_role_store'])->name('management.assign.existing.role.store');
    // seller part start
    Route::get('/management/role/seller/edit/{id}', [ManagementController::class, 'seller_edit'])->name('management.assign.existing.role.seller.edit');
    Route::post('/management/role/seller/update/{id}', [ManagementController::class, 'seller_update'])->name('management.assign.existing.role.seller.update');

    Route::post('/management/role/seller/down/{id}', [ManagementController::class, 'assign_existing_role_seller_down'])->name('management.assign.existing.role.seller.down');
    Route::post('/management/role/seller/block/{id}', [ManagementController::class, 'assign_existing_role_seller_block'])->name('management.assign.existing.role.seller.block');
    Route::get('/management/role/seller/delete/{id}', [ManagementController::class, 'assign_existing_role_seller_delete'])->name('management.assign.existing.role.seller.delete');
   //seller part end

   //user part start
    Route::get('/management/role/user/edit/{id}', [ManagementController::class, 'user_edit'])->name('management.assign.existing.role.user.edit');
    Route::post('/management/role/user/update/{id}', [ManagementController::class, 'user_update'])->name('management.assign.existing.role.user.update');
    Route::post('/management/role/user/block/{id}', [ManagementController::class, 'assign_existing_role_user_block'])->name('management.assign.existing.role.user.block');
    Route::get('/management/role/user/delete/{id}', [ManagementController::class, 'assign_existing_role_user_delete'])->name('management.assign.existing.role.user.delete');
    //user part end

    //block users part start
    Route::get('/management/block',[ManagementController::class, 'block_user'])->name('management.user.block');
    Route::post('/management/unblock/{id}',[ManagementController::class, 'unblock_user'])->name('management.user.unblock');
    Route::get('/management/delete/{id}',[ManagementController::class, 'delete_block_user'])->name('management.block.user.delete');
    //block users part end

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

//add product routes start
Route::resource('/product',ProductController::class);
Route::post('/product/status/{id}',[ProductController::class,'status'])->name('product.status');
//add product routes end

// Backend Routes end
});
