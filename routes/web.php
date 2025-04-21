<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\ClientColloboratorController;
use App\Http\Controllers\ClientContactController;
use App\Http\Controllers\ClientEventController;
use App\Http\Controllers\ClientPostController;
use App\Http\Controllers\ClientShopController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Livewire\AdminPostBuilder;
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

Route::get('/login', [LoginController::class, 'show'])->name('sign.in.show');
Route::post('/login', [LoginController::class, 'login'])->name('sign.in');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get("/", [HomeController::class, 'index'])->name('home');

Route::get('/posts', [ClientPostController::class, 'index'])->name('client.posts.index');
Route::get('/posts/{slug}', [ClientPostController::class, 'show'])->name('client.posts.show');

Route::get('/collaborators', [ClientColloboratorController::class, 'index'])->name('client.collaborators.index');

Route::get('/shop', [ClientShopController::class, 'index'])->name('client.shop.index');
Route::get('/shop/{slug}', [ClientShopController::class, 'show'])->name('client.shop.show');

Route::get('/contact-us', [ClientContactController::class, 'index'])->name('client.contact.index');
Route::post('/contact-us', [ClientContactController::class, 'store'])->name('client.contact.store');

Route::get('/events', [ClientEventController::class, 'index'])->name('client.events.index');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/profile', [UserController::class, 'edit'])->name('admin.users.edit');

    Route::get('/blog-categories', [PostCategoryController::class, 'index'])->name('admin.blog-categories.index');
    Route::get('/blog-categories/create', [PostCategoryController::class, 'create'])->name('admin.blog-categories.create');
    Route::post('/blog-categories', [PostCategoryController::class, 'store'])->name('admin.blog-categories.store');
    Route::get('/blog-categories/{postCategory}', [PostCategoryController::class, 'edit'])->name('admin.blog-categories.edit');
    Route::put('/blog-categories/{postCategory}', [PostCategoryController::class, 'update'])->name('admin.blog-categories.update');
    Route::delete('/blog-categories/{postCategory}', [PostCategoryController::class, 'destroy'])->name('admin.blog-categories.destroy');

    Route::delete('post/{postId}/image/{imageId}', [PostController::class, 'destroyImage'])->name('admin.posts.image.destroy');
    Route::put('post/{postId}/image/{imageId}', [PostController::class, 'updateImage'])->name('admin.posts.image.update');
    Route::get('/posts/search', [PostController::class, 'search'])->name('admin.posts.search');
    Route::get('/posts', [PostController::class, 'index'])->name('admin.posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('admin.posts.store');
    Route::get('/posts/{post}',  [PostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('admin.posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
    Route::post('/posts/update-select2', [PostController::class, 'loadSearchOptions']);

    Route::get('/shop-categories', [ProductCategoryController::class, 'index'])->name('admin.shop-categories.index');
    Route::get('/shop-categories/create', [ProductCategoryController::class, 'create'])->name('admin.shop-categories.create');
    Route::post('/shop-categories', [ProductCategoryController::class, 'store'])->name('admin.shop-categories.store');
    Route::get('/shop-categories/{productCategory}', [ProductCategoryController::class, 'edit'])->name('admin.shop-categories.edit');
    Route::put('/shop-categories/{productCategory}', [ProductCategoryController::class, 'update'])->name('admin.shop-categories.update');
    Route::delete('/shop-categories/{productCategory}', [ProductCategoryController::class, 'destroy'])->name('admin.shop-categories.destroy');

    Route::delete('product/{productId}/image/{imageId}', [ProductController::class, 'destroyImage'])->name('admin.product.image.destroy');
    Route::put('product/{productId}/image/{imageId}', [ProductController::class, 'updateImage'])->name('admin.product.image.update');
    Route::get('/products/search', [ProductController::class, 'search'])->name('admin.products.search');
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::post('/products/update-select2', [ProductController::class, 'loadSearchOptions']);
    Route::post('/admin/products/preview', [ProductController::class, 'preview'])->name('admin.products.preview');

    Route::get('/collaborators', [CollaboratorController::class, 'index'])->name('admin.collaborators.index');
    Route::get('/collaborators/create', [CollaboratorController::class, 'create'])->name('admin.collaborators.create');
    Route::post('/collaborators', [CollaboratorController::class, 'store'])->name('admin.collaborators.store');
    Route::get('/collaborators/{collaborator}', [CollaboratorController::class, 'edit'])->name('admin.collaborators.edit');
    Route::put('/collaborators/{collaborator}', [CollaboratorController::class, 'update'])->name('admin.collaborators.update');
    Route::delete('/collaborators/{collaborator}', [CollaboratorController::class, 'destroy'])->name('admin.collaborators.destroy');


    Route::delete('event/{eventId}/image/{imageId}', [EventsController::class, 'destroyImage'])->name('admin.event.image.destroy');
    Route::put('event/{eventId}/image/{imageId}', [EventsController::class, 'updateImage'])->name('admin.event.image.update');
    Route::get('/events', [EventsController::class, 'index'])->name('admin.events.index');
    Route::get('/events/create', [EventsController::class, 'create'])->name('admin.events.create');
    Route::post('/events', [EventsController::class, 'store'])->name('admin.events.store');
    Route::get('/events/{event}', [EventsController::class, 'edit'])->name('admin.events.edit');
    Route::put('/events/{event}', [EventsController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{event}', [EventsController::class, 'destroy'])->name('admin.events.destroy');

    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

    Route::get('/contact', [ClientContactController::class, 'adminIndex'])->name('admin.contact.index');
    Route::delete('/contact/{contact}', [ClientContactController::class, 'destroy'])->name('admin.contact.destroy');

    Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('admin.ckeditor.upload');
    Route::post('/ckeditor/delete-image', [CKEditorController::class, 'deleteImage'])->name('admin.ckeditor.delete-image');
});
