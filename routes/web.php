<?php

use Illuminate\Support\Facades\Route;

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
    UserController,
    PackageController,
    UserPackageController,
    DeliveryDayController,
    UserPackagePaymentController
};

use App\Http\Controllers\frontend\{
    PageController as
    FrontPageController,
    PostController as FrontPostController,
    ServiceController
};

Route::get('/', [FrontPageController::class, 'home'])->name('home');
Route::post('/getPackages', [FrontPageController::class, 'getPackages'])->name('getPackages');
Route::post('/selectPackage', [FrontPageController::class, 'selectPackage'])->name('selectPackage');
Route::get('/home', [FrontPageController::class, 'home']);
Route::get('/getNearby', [FrontPageController::class, 'getNearby'])->name('getNearby');
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
        //Route::view('dashboard', 'backend.dashboard.dashboard')->name('home');
        Route::any('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('medias', [MediaController::class, 'index'])->name('media.index');

        //  Accounts
        Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
            Route::get('/setting', [AdminController::class, 'settings'])->name('settings');
            Route::get('/account', [AdminController::class, 'account'])->name('account');
            Route::post('/change/information', [AdminController::class, 'basicInformation'])->name('information');
            Route::post('/change/password', [AdminController::class, 'changePassword'])->name('password');
            Route::any('/delete/{var?}', [AdminController::class, 'destroy'])->name('destroy');
            Route::post('/updateSettings', [AdminController::class, 'updateSettings'])->name('updateSettings');
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
            Route::any('/import_csv', [UserController::class, 'import_csv'])->name('import_csv');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::get('/test', [UserController::class, 'test'])->name('test');
            Route::post('/store/{var?}', [UserController::class, 'store'])->name('store'); //assign_package
            Route::get('/edit/{var?}', [UserController::class, 'edit'])->name('edit');
            Route::get('/assign_package/{var?}', [UserController::class, 'assign_package'])->name('assign_package');
            Route::any('/createUserAsingCard/{var?}', [UserController::class, 'createUserAsingCard'])->name('createUserAsingCard');
            Route::any('/addnewCardCustomer/{var?}', [UserController::class, 'addnewCardCustomer'])->name('addnewCardCustomer');
            Route::get('/assign_total_credits/{var?}', [UserController::class, 'assign_total_credits'])->name('assign_total_credits');
            Route::post('/assign_package_submission/', [UserController::class, 'assign_package_submission'])->name('assign_package_submission');
            Route::post('/assign_package_payments/', [UserController::class, 'assign_package_payments'])->name('assign_package_payments');
            Route::post('/package_detail/', [UserController::class, 'package_detail'])->name('package_detail');
            Route::post('/update/{var?}', [UserController::class, 'update'])->name('update');
            Route::get('/show/{var?}', [UserController::class, 'show'])->name('show');
            Route::delete('/delete/{var?}', [UserController::class, 'destroy'])->name('destroy');
            Route::get('/deactivate/{var?}', [UserController::class, 'deactivate'])->name('deactivate');
            Route::get('/activate/{var?}', [UserController::class, 'activate'])->name('activate');
            Route::post('/{id}/restore', [UserController::class, 'restore'])->name('restore');
        });

        //  deliveries Day
        Route::group(['prefix' => 'delivery_days', 'as' => 'delivery_days.'], function () {
            Route::any('/', [DeliveryDayController::class, 'index'])->name('index');
            Route::get('/create/{var?}', [DeliveryDayController::class, 'create'])->name('create');
            Route::get('/TestDeliveryRoutes/{var?}', [DeliveryDayController::class, 'TestDeliveryRoutes'])->name('TestDeliveryRoutes');
            Route::post('/store/{var?}', [DeliveryDayController::class, 'store'])->name('store');
            Route::get('/show/{var?}', [DeliveryDayController::class, 'show'])->name('show');
            Route::get('/cron_test', [DeliveryDayController::class, 'cron_test'])->name('cron_test');
            Route::post('/canceled/{var?}', [DeliveryDayController::class, 'canceled'])->name('canceled');
            Route::get('/designer_report/{var?}', [DeliveryDayController::class, 'designer_report'])->name('designer_report');
            Route::get('/routes_labels/{var?}', [DeliveryDayController::class, 'routes_labels'])->name('routes_labels');
            Route::post('/get_routes_labels_files/', [DeliveryDayController::class, 'get_routes_labels_files'])->name('get_routes_labels_files');
            Route::get('create_label_files/{var?}', [DeliveryDayController::class, 'create_label_files'])->name('create_label_files');
        });

        //  deliveries
        Route::group(['prefix' => 'deliveries', 'as' => 'deliveries.'], function () {
            Route::any('/', [DeliveryDayController::class, 'deliveries'])->name('index');
        });

        //  user_package_subscriptons
        Route::group(['prefix' => 'user_packages', 'as' => 'user_packages.'], function () {
            Route::any('/', [UserPackageController::class, 'index'])->name('index');
            Route::get('/show/{var?}', [UserPackageController::class, 'show'])->name('show');
            Route::post('/runBulkTrasections/', [UserPackageController::class, 'runBulkTrasections'])->name('runBulkTrasections');
            Route::post('/cancelThisWeek/', [UserPackageController::class, 'cancelThisWeek'])->name('cancelThisWeek');
            Route::post('/suspend_delivery/', [UserPackageController::class, 'suspend_delivery'])->name('suspend_delivery');
            Route::get('/activate_delivery/{var?}', [UserPackageController::class, 'activate_delivery'])->name('activate_delivery');
            Route::any('/delete/{var?}', [UserPackageController::class, 'destroy'])->name('destroy');
        });
        //  Packages
        Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {
            Route::any('/', [PackageController::class, 'index'])->name('index');
            Route::get('/create', [PackageController::class, 'create'])->name('create');
            Route::post('/store/{var?}', [PackageController::class, 'store'])->name('store');
            Route::get('/edit/{var?}', [PackageController::class, 'edit'])->name('edit');
            Route::post('/update/{var?}', [PackageController::class, 'update'])->name('update');
            Route::get('/show/{var?}', [PackageController::class, 'show'])->name('show');
            Route::delete('/delete/{var?}', [PackageController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore', [PackageController::class, 'restore'])->name('restore');
        });
        // Route::any('/transactions/{var?}', [UserPackagePaymentController::class, 'transactions'])->name('transactions');
        Route::group(['prefix' => 'transactions', 'as' => 'transactions.'], function () {
            Route::any('/', [UserPackagePaymentController::class, 'index'])->name('index');
            Route::any('/review', [UserPackagePaymentController::class, 'review'])->name('review');
            Route::any('/{var?}', [UserPackagePaymentController::class, 'index'])->name('user_transections');
            Route::any('/show/{var?}', [UserPackagePaymentController::class, 'show'])->name('show');
            Route::any('/refund/{var?}', [UserPackagePaymentController::class, 'refund'])->name('refund');
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
