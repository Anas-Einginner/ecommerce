<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminRolesController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\HeritageCardController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Logs\LogsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderItemUserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Permission\PermissionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\Role\RolesController;
use App\Http\Controllers\Stripe\StripeController;
use App\Http\Controllers\WishlistController;
use App\Models\Category;
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
// Route::get('category',function () {
//     return view('dashboard.category.index');
// })->name('category');


Route::get('lang/{locale}', LocaleController::class)
    ->name('lang.switch');

// Route::get('/index', function () {
//     return view('ecommerce');
// })->name('index');

/*
|--------------------------------------------------------------------------
| 🌍 Ecommerce Front
|--------------------------------------------------------------------------
*/

Route::prefix('ecommerce')
    ->name('ecommerce.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Public Pages
        |--------------------------------------------------------------------------
        */

        Route::controller(PageController::class)->group(function () {
            Route::get('/home', 'home')->name('home');
            Route::get('/shop', 'shop')->name('shop');
            Route::get('/contact', 'contact')->name('contact');
            Route::get('/artisan', 'artisans')->name('artisan');
            Route::get('/checkout', 'checkout')->name('checkout');
        });

        Route::get('/shop/products', [ProductsController::class, 'products'])
            ->name('shop.products');
        Route::get('/product/{slug}', [ProductsController::class, 'show'])
            ->name('product.show');
        Route::get('/products/search', [ProductsController::class, 'search'])->name('products.search');
        Route::post('store', [ReviewsController::class, 'store'])->name('store.review');

        Route::post('/checkout/place-order', [OrderController::class, 'placeOrder'])
            ->name('checkout.placeOrder');
        Route::post('/orders/{id}/refund', [OrderController::class, 'refund']);
        /*
        |--------------------------------------------------------------------------
        | Authenticated Pages
        |--------------------------------------------------------------------------
        */

        Route::middleware(['auth', 'active'])
            ->controller(PageController::class)
            ->group(function () {
                Route::get('/account', 'account')->name('account');
                Route::post('/account', 'updateAccount')->name('account.update');
            });
        Route::post('store', [ReviewsController::class, 'store'])->name('store.review');
        Route::post('/checkout/place-order', [OrderController::class, 'placeOrder'])
            ->name('checkout.placeOrder');
        Route::controller(OrderController::class)->group(function () {
            Route::post('/checkout/place-order','placeOrder')
            ->name('checkout.placeOrder');
            Route::post('/orders/{id}/refund', 'refund')
                ->name('refund');
        });

        Route::controller(OrderItemUserController::class)->group(function () {

        
    Route::get('/order-items-user-data/{order_id}', 'getdata')
        ->name('dash.Order-item-user.getdata');

    Route::get('/order-items-user/{order_id}', 'view')
        ->name('dash.order-items-user.view');
        });
    });

/*
|--------------------------------------------------------------------------
| 🛒 User Actions (Cart & Wishlist)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Cart
    |--------------------------------------------------------------------------
    */

    Route::prefix('cart')
        ->name('cart.')
        ->controller(CartController::class)
        ->group(function () {

            Route::get('/', 'index')->name('index');
            Route::get('/count', 'count')->name('count');
            Route::post('/add', 'add')->name('add');
            Route::post('/add-all', 'addAll')->name('addAll');
            Route::post('/update', 'update')->name('update');
            Route::post('/remove', 'remove')->name('remove');
        });

    /*
    |--------------------------------------------------------------------------
    | Wishlist
    |--------------------------------------------------------------------------
    */

    Route::prefix('wishlist')
        ->name('wishlist.')
        ->controller(WishlistController::class)
        ->group(function () {

            Route::get('/', 'index')->name('index');
            Route::get('/count', 'count')->name('count');
            Route::post('/toggle', 'toggle')->name('toggle');
            Route::delete('/remove/{id}', 'remove')->name('remove');
        });
});
Route::prefix('ecommerce/dashboard')
    ->middleware(['auth', 'active', 'not_customer', 'roles.active'])
    ->name('dash.')
    ->group(function () {



        /*

            $prefix,
            $controller,
            $namePrefix,
            $permissionBase = null,
            array $actions = ['view', 'getdata', 'store', 'update', 'delete', 'active', 'inactive'],
            callable $extras = null  ✅ هنا الجديد
  */
        Route::dashboardModule(
            'logo',
            LogsController::class,
            'logo.',
            null,
            ['view']
        );

        Route::dashboardModule(
            'profile',
            ProfileController::class,
            'profile.',
            null,
            ['view', 'update']
        );
        // Admins (view + getdata + store + update + delete + active/inactive)
        Route::dashboardModule(
            'admin',
            AdminController::class,
            'admin.',
            'user',
            ['view', 'getdata', 'store', 'update', 'delete', 'active', 'inactive']
        );

        // Roles
        Route::dashboardModule(
            'roles',
            RolesController::class,
            'roles.',
            'role',
            ['view', 'getdata', 'store', 'update', 'delete', 'active', 'inactive'],
            function ($perm) {
                $route = Route::get('{role}/permissionsChecked', 'permissionsChecked')
                    ->name('permissionsChecked');

                if (!empty($perm)) {
                    $route->middleware("permission:$perm.view");
                }
            }
        );


        // Permissions
        Route::dashboardModule(
            'permissions',
            PermissionsController::class,
            'permissions.',
            'permission',
            ['view', 'getdata', 'store', 'update', 'delete', 'active', 'inactive']
        );

        // Admin-Role
        Route::dashboardModule(
            'admin-role',
            AdminRolesController::class,
            'admin-role.',
            'user_roles',
            ['view', 'getdata', 'store', 'update', 'delete', 'active', 'inactive'],
            function ($permissionBase) {

                Route::get('/roles-checked/{user}', 'rolesChecked')
                    ->name('rolesChecked')
                    ->middleware("permission:$permissionBase.view");
            }
        );

        //stripe settings
        Route::get('stripe/settings', [StripeController::class, 'index'])
            ->name('stripe.settings');
        // حفظ البيانات
        Route::post('stripe/settings', [StripeController::class, 'store'])
            ->name('stripe.settings.store');

        /*
            Route::dashboardModule(
    'payments',
    PaymentSettingController::class,
    'payments.',
    'payment',
    ['view', 'update'],
    function ($permissionBase) {

        // Stripe Settings Page
        Route::get('stripe', 'stripe')
            ->name('stripe')
            ->middleware("permission:$permissionBase.view");

        Route::post('stripe', 'updateStripe')
            ->name('stripe.update')
            ->middleware("permission:$permissionBase.update");
    }
);
            */

        // Categories
        Route::dashboardModule(
            'categories',
            CategoriesController::class,
            'categories.',
            'category',
            ['view', 'getdata', 'store', 'update', 'delete', 'active', 'inactive']
        );
        Route::dashboardModule(
            'products',
            ProductsController::class,
            'products.',
            'product',
            ['view', 'getdata', 'store', 'update', 'delete', 'active', 'inactive']
        );
        Route::dashboardModule(
            'heritage',
            HeritageCardController::class,
            'heritage.',
            'heritage',
            ['view', 'getdata', 'store', 'update', 'delete', 'active', 'inactive']
        );
        Route::dashboardModule(
            'artisans',
            ArtisanController::class,
            'artisans.',
            'artisan',
            ['view', 'getdata', 'store', 'update', 'delete', 'active', 'inactive']
        );
        Route::dashboardModule(
            'messages',
            MessageController::class,
            'messages.',
            'message',
            ['view', 'getdata', 'store', 'update', 'delete']
        );
        Route::dashboardModule(
            'info',
            InfoController::class,
            'info.',
            'info',
            ['view', 'getdata', 'store', 'update', 'delete']
        );
        Route::dashboardModule(
            'reviews',
            ReviewsController::class,
            'reviews.',
            'reviews',
            ['view', 'getdata', 'update', 'delete']
        );
        Route::dashboardModule(
            'Order',
            OrderController::class,
            'Order.',
            'Order',
            ['view', 'getdata', 'update', 'delete']
        );
        Route::dashboardModule(
            'Order-item',
            OrderItemController::class,
            'Order-item.',
            'Order-item',
            ['view', 'getdata', 'update', 'delete']
        );
        Route::dashboardModule(
            'Order-item-user',
            OrderItemController::class,
            'Order-item-user.',
            'Order-item-user',
            ['view', 'getdata', 'update', 'delete']
        );
    });






require __DIR__ . '/auth.php';
