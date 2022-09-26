<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\backend\{
    AdminController,
    CategoryController,
    ElementController,
    MediaController,
    MenuController,
    PageController,
    PostController,
    TagController,
    UserController
};

use App\Http\Controllers\frontend\{
    PageController as
    FrontPageController,
    PostController as FrontPostController,
    ServiceController
};

Route::get('/', [FrontPageController::class, 'home'])->name('home');
Route::get('/home', [FrontPageController::class, 'home']);
Route::get('/category/{slug}', [FrontPostController::class, 'showCategory'])->name('category.show');
Route::get('/tag/{slug}', [FrontPostController::class, 'showTag'])->name('tag.show');
Route::get('/blog/{slug}', [FrontPostController::class, 'show'])->name('blog.show');
Route::get('/blog', [FrontPostController::class, 'index'])->name('blogs.index');
Route::get('/author/{name}', [FrontPostController::class, 'author'])->name('author.index');
Route::get('/search/', [FrontPageController::class, 'search'])->name('search.index');
Route::get('/sitemap.xml', [App\Http\Controllers\frontend\SitemapController::class, 'index']);

Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');

Route::prefix('/password')->as('password.')->group(function () {
    Route::post('/email', [App\Http\Controllers\frontend\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
    Route::get('/reset/{token}', [App\Http\Controllers\frontend\ForgotPasswordController::class, 'showResetForm'])->name('reset');
    Route::post('/reset', [App\Http\Controllers\frontend\ForgotPasswordController::class, 'reset'])->name('update');
    Route::get('/reset/', [App\Http\Controllers\frontend\ForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::group(['middleware' => 'role:user', 'prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [App\Http\Controllers\Frontend\UserController::class, 'dashboard'])->name('dashboard');
        Route::post('/profile/update', [App\Http\Controllers\Frontend\UserController::class, 'update'])->name('profile.update');
        Route::post('/password/update', [App\Http\Controllers\Frontend\UserController::class, 'password'])->name('password.update');
    });
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::view('login', 'backend.login.login')->name('login');
        Route::post('login', [AdminController::class, 'login'])->name('auth');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::view('dashboard', 'backend.dashboard.dashboard')->name('home');
        Route::view('/', 'backend.dashboard.dashboard');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('medias', [MediaController::class, 'index'])->name('media.index');

        //  Accounts
        Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
            Route::get('/account', [AdminController::class, 'account'])->name('settings');
            Route::post('/change/information', [AdminController::class, 'basicInformation'])->name('information');
            Route::post('/change/password', [AdminController::class, 'changePassword'])->name('password');
        });
        //Sub Admins
        Route::group(['prefix' => 'subadmins', 'as' => 'subadmins.'], function () {
            Route::any('/', [AdminController::class, 'listSubAdmins'])->name('list');
            Route::get('/create/{var?}', [AdminController::class, 'createAdmin'])->name('create');
            Route::get('/show/{var?}', [AdminController::class, 'show'])->name('show');
            Route::get('/edit/{var?}', [AdminController::class, 'editAdmin'])->name('edit');
            Route::post('/store/{var?}', [AdminController::class, 'storeAdmin'])->name('store');
            Route::post('/update/{var?}', [AdminController::class, 'update'])->name('update');
            Route::any('/delete/{var?}', [AdminController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore', [AdminController::class, 'restore'])->name('restore');
        });
        //  Users
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::any('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store/{var?}', [UserController::class, 'store'])->name('store');
            Route::get('/show/{var?}', [UserController::class, 'show'])->name('show');
            Route::delete('/delete/{var?}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore', [UserController::class, 'restore'])->name('restore');
        });

        //  Categories
        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::any('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/store', [CategoryController::class, 'store'])->name('store');
            Route::post('/{slug}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::post('/{slug}/update', [CategoryController::class, 'update'])->name('update');
        });

        //  Tags
        Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
            Route::any('', [TagController::class, 'index'])->name('index');
            Route::get('/create', [TagController::class, 'create'])->name('create');
            Route::post('/store', [TagController::class, 'store'])->name('store');
            Route::post('/{slug}/edit', [TagController::class, 'edit'])->name('edit');
            Route::post('/{slug}/update', [TagController::class, 'update'])->name('update');
        });

        //  Posts
        Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
            Route::any('/', [PostController::class, 'index'])->name('index');
            Route::get('/create', [PostController::class, 'create'])->name('create');
            Route::post('/store', [PostController::class, 'store'])->name('store');
            Route::post('/{slug}/edit', [PostController::class, 'edit'])->name('edit');
            Route::post('/update', [PostController::class, 'update'])->name('update');
            Route::delete('/{id}/delete', [PostController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore', [PostController::class, 'restore'])->name('restore');
        });

        //  Menus
        Route::group(['prefix' => 'menus', 'as' => 'menus.'], function () {
            Route::get('/show/{menu:slug}', [MenuController::class, 'show'])->name('show');
            Route::post('/store', [MenuController::class, 'store'])->name('store');
            Route::post('/list', [MenuController::class, 'listMenu'])->name('listMenu');
            Route::post('/delete', [MenuController::class, 'delete'])->name('delete');
        });

        //  Pages
        Route::group(['prefix' => 'pages', 'as' => 'pages.'], function () {
            Route::any('/', [PageController::class, 'index'])->name('index');
            Route::get('/create', [PageController::class, 'create'])->name('create');
            Route::post('/edit/{page:slug}', [PageController::class, 'create'])->name('edit');
            Route::put('/update/{page}', [PageController::class, 'update'])->name('update');
            Route::delete('/{id}/disable', [PageController::class, 'disable'])->name('disable');
            Route::delete('/{id}/destroy', [PageController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore', [PageController::class, 'restore'])->name('restore');
        });

        Route::post('getChildPageElement', [PageController::class, 'getChildPageElement'])->name('getChildPageElement');
        Route::post('getElement', [PageController::class, 'getElement'])->name('getElement');
        Route::post('addSection', [PageController::class, 'addSection'])->name('addSection');

        Route::get('page/edit/element/{id?}', [PageController::class, 'editInnerElement'])->name('editInnerElement');
        Route::post('InnerElement/store', [PageController::class, 'storeInnerElement'])->name('storeInnerElement');
        Route::post('storeChildPe', [PageController::class, 'storeChildPe'])->name('storeChildPe');
        Route::post('InnerElement/update', [PageController::class, 'updateInnerElement'])->name('updateInnerElement');
        Route::post('getPageSections', [PageController::class, 'getPageSections'])->name('getPageSections');
        Route::post('section/order', [PageController::class, 'sectionOrder'])->name('parent.order');
        Route::post('section/delete', [PageController::class, 'deleteSection'])->name('delete.section');
        Route::post('change/selector', [PageController::class, 'changeSelector'])->name('changeSelector');
        Route::post('elements/delete', [PageController::class, 'deleteElements'])->name('element.delete');

        Route::any('elements', [ElementController::class, 'index'])->name('elements.index');
        Route::get('element/create', [ElementController::class, 'create'])->name('element.create');
        Route::post('element/store', [ElementController::class, 'store'])->name('element.store');
        Route::get('element/edit/{element:id}', [ElementController::class, 'edit'])->name('element.edit');
        Route::post('element/update', [ElementController::class, 'update'])->name('element.update');
        Route::post('elementDelete', [ElementController::class, 'delete'])->name('elementDelete');

        Route::post('field/create', [ElementController::class, 'fieldCreate'])->name('field.create');
        Route::post('field/get', [ElementController::class, 'fieldGet'])->name('field.get');
        Route::post('field/update', [ElementController::class, 'fieldUpdate'])->name('field.update');
        Route::post('field/delete', [ElementController::class, 'fieldDelete'])->name('field.delete');
    });
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE';
});
Route::get('/cli/migrate', function () {
    Artisan::call('migrate');
});
Route::get('/cli/config', function () {
    Artisan::call('config:cache');
});
Route::get('/cli/con', function () {
    Artisan::call('cache:clear');
});
Route::get('/cli/seed', function () {
    Artisan::call('db:seed');
});
Route::get('/cli/view', function () {
    Artisan::call('view:clear');
});
Route::get('/cli/queue', function () {
    Artisan::call('queue:work');
});
Route::get('/cli/sto', function () {
    Artisan::call('storage:link');
});
Route::get('/cli/route', function () {
    Artisan::call('route:clear');
});
Route::get('/cli/cache', function () {
    Artisan::call('route:cache');
});
Route::get('/cli/bread', function () {
    Artisan::call('vendor:publish', '--provider="DaveJamesMiller\Breadcrumbs\BreadcrumbsServiceProvider"');
});

Route::get('/{page:slug}', [FrontPageController::class, 'show'])->name('page.show');
