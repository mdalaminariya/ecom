<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Frontend\AuthenticationController;
use App\Http\Controllers\Frontend\CategoryProductController;
use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController as BackendHomeController;

Auth::routes(['verify' => true]);

//authentication routes start
Route::get('auth/login',[AuthenticationController::class,'login'])->name('auth.login');
Route::post('auth/login',[AuthenticationController::class,'login_post'])->name('auth.login');
Route::get('auth/register',[AuthenticationController::class,'register'])->name('auth.register');
Route::post('auth/register',[AuthenticationController::class,'register_post'])->name('auth.register.post');

//authentication routes end

// Email Verification
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
// Frontend Routes start

//home page start
Route::get('/',[HomeController::class,'index'])->name('frontend.home');
Route::get('/category/product/{slug}',[CategoryProductController::class,'index'])->name('category.product');
Route::get('/product-search', [CategoryProductController::class,'search'])->name('product.search');
//home page end
//Shop category page start
Route::get('/shop',[CategoryProductController::class,'shop'])->name('frontend.shop');
//Shop category page end
//shop cart page start
Route::get('/shopping/cart',[CartController::class,'index'])->name('shopping.cart');
Route::get('/shopping/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/shopping/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/shopping/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
//shop cart page end

//product Checkout page start
Route::get('/product/checkout',[CheckOutController::class,'checkout'])->middleware(['auth', 'verified'])->name('product.checkout');
//product Checkout page end

//Tracking order page start
Route::get('/tracking/order',[CheckOutController::class,'tracking_order'])->name('tracking.order');
//Tracking order page end

//contact page start
Route::get('/contact',[ContactController::class,'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
//contact page end

// Place order route
Route::post('/checkout/place-order', [CheckOutController::class, 'placeOrder'])->name('checkout.placeOrder');
//Product details page start
Route::get('/product/details/{slug}',[CategoryProductController::class,'product_details'])->name('product.details');
//Product details page end
//comment route start
Route::post('/comments/store',[CommentController::class,'store'])->name('comments.store');
//comment route end
// Frontend blog routes
Route::get('/blogs', [BlogController::class, 'list'])->name('blog.list');
Route::get('/blogs/{slug}', [BlogController::class, 'blog_details'])->name('blog.details');
// Frontend blog details route
    Route::post('/blog/{blog}/comment', [BlogController::class, 'storeComment'])->name('blog.comment.store')->middleware('auth');
//subcribe route start
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
//subcribe route end
//frontend Routes end


// Backend Routes start
Route::middleware(['auth', 'verified'])->group(function () {
    //user profile show route start
    Route::get('/user/{id}/profile', [UserController::class, 'profile'])->name('user.profile');
    //user profile show route end

    //user message send route start
Route::middleware('auth')->group(function () {
    Route::get('/inbox', [ChatController::class, 'inbox'])->name('inbox');
    Route::get('/chat/{id}', [ChatController::class, 'open'])->name('chat.open');
    Route::post('/send-message', [ChatController::class, 'send'])->name('chat.send');
});
    //user message send route end

    //dashboard home route start
    Route::get('/home', [BackendHomeController::class, 'index'])->name('dashboard.home');
    //dashboard home route end

    //account settings route start
    Route::get('/home/account/settings',[AccountSettingsController::class,'index'])->name('home.account.settings');
    Route::post('name/update',[AccountSettingsController::class,'name_update'])->name('name.update');
    Route::post('email/update',[AccountSettingsController::class,'email_update'])->name('email.update');
    Route::post('dashboard/password/update',[AccountSettingsController::class,'password_update'])->name('dashboard.password.update');
    Route::post('dashboard/image/update',[AccountSettingsController::class,'image_update'])->name('dashboard.image.update');
    //account settings route end
});

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

    //ban user part start
    Route::post('user/ban/{id}', [ManagementController::class, 'ban_user'])->name('management.user.ban');
    Route::get('user/banned', [ManagementController::class, 'banned_users_show'])->name('management.user.banned');
    Route::get('banned/user/delete/{id}', [ManagementController::class, 'banned_user_delete'])->name('management.banned.user.delete');
    Route::post('user/unban/{id}', [ManagementController::class, 'unban_user'])->name('management.user.unban');
    //ban user part end

    //block users part start
    Route::get('/management/block',[ManagementController::class, 'block_user'])->name('management.user.block');
    Route::post('/management/unblock/{id}',[ManagementController::class, 'unblock_user'])->name('management.user.unblock');
    Route::get('/management/delete/{id}',[ManagementController::class, 'delete_block_user'])->name('management.block.user.delete');
    //block users part end

//dashboard management route end

// newsletter subscribe route start
Route::get('/subscribe', [NewsletterController::class, 'index'])->name('subscriber');
Route::get('/subscribe/delete/{id}', [NewsletterController::class, 'delete'])->name('subscriber.delete');
// newsletter subscribe route end

//product comment management route start
Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
Route::get('/comments/delete/{id}', [CommentController::class, 'delete'])->name('comments.delete');
//product comment management route end

//Blog comment management route start
Route::get('/blog/comments/blog',[BlogController::class,'blog_comments'])->name('blog.comments');
Route::get('/blog/comments/delete/{id}',[BlogController::class,'blog_comments_delete'])->name('blog.comments.delete');
//Blog comment management route end

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
Route::post('/product/best/seller/{slug}',[ProductController::class,'best_seller'])->name('product.best.seller');
Route::post('/product/banner/{id}',[ProductController::class,'banner'])->name('product.banner');
//add product routes end

// Blog routes
Route::prefix('blog')->group(function () {
    // Dashboard CRUD
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');           // list blogs
    Route::get('/create', [BlogController::class, 'create'])->name('blog.create');    // create form
    Route::post('/', [BlogController::class, 'store'])->name('blog.store');           // store blog
    Route::get('/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit');   // edit form
    Route::put('/{blog}', [BlogController::class, 'update'])->name('blog.update');    // update blog
    Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy'); // delete blog

    // contact message page start
    Route::get('/contact',[ContactController::class,'contact_messages'])->name('contacts.messages');
    Route::get('/contact/delete/{id}',[ContactController::class,'delete'])->name('contacts.delete');
    //contact message page end

    // Custom frontend routes
    Route::post('/status/{id}', [BlogController::class,'status'])->name('blog.status');      // toggle status
    });
// Backend Routes end
});
