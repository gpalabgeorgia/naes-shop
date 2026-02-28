<?php

use App\Http\Controllers\Admin\OrdersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SectionsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\CouponsController;

use App\Http\Controllers\Front\IndexController as FrontIndexController;
use App\Http\Controllers\Front\ProductsController as FrontProductsController;
use App\Http\Controllers\Front\UsersController;
use App\Http\Controllers\Front\OrdersController as FrontOrdersController;
use App\Models\Category;



Route::prefix('/admin')->namespace('Admin')->group(function() {
    // All the admin routes will be defined here
    Route::match(['get', 'post'],'/', [AdminController::class, 'login']);

    Route::group(['middleware'=>['admin']], function() {

        Route::get('dashboard', [AdminController::class, 'dashboard']);

        Route::get('settings', [AdminController::class, 'settings']);

        Route::get('logout', [AdminController::class, 'logout']);

        Route::post('check-current-pwd', [AdminController::class, 'chkCurrentPassword']);

        Route::post('update-current-pwd', [AdminController::class, 'updateCurrentPassword']);

        Route::match(['get', 'post'], 'update-admin-details', [AdminController::class, 'updateAdminDetails']);

        // Sections
        Route::get('sections', [SectionsController::class, 'sections']);
        Route::post('update-section-status', [SectionsController::class, 'updateSectionsStatus']);

        // Brands
        Route::get('brands', [BrandController::class, 'brands']);
        Route::post('update-brand-status', [BrandController::class, 'updateBrandStatus']);
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', [BrandController::class, 'addEditBrand']);
        Route::get('delete-brand/{id}', [BrandController::class, 'deleteBrand']);

        // Categories
        Route::get('categories', [CategoryController::class, 'categories']);
        Route::post('update-category-status', [CategoryController::class, 'updateCategoryStatus']);
        Route::match(['get', 'post'], 'add-edit-category/{id?}', [CategoryController::class, 'addEditCategory']);
        Route::post('append-categories-level', [CategoryController::class, 'appendCategoryLevel']);
        Route::get('delete-category-image/{id}', [CategoryController::class, 'deleteCategoryImage']);
        Route::get('delete-category/{id}', [CategoryController::class, 'deleteCategory']);

        // Products
        Route::get('products', [ProductController::class, 'products']);
        Route::post('update-product-status', [ProductController::class, 'updateProductStatus']);
        Route::get('delete-product/{id}', [ProductController::class, 'deleteProduct']);
        Route::match(['get', 'post'], 'add-edit-product/{id?}', [ProductController::class, 'addEditProduct']);
        Route::get('delete-product-image/{id}', [ProductController::class, 'deleteProductImage']);
        Route::get('delete-product-video/{id}', [ProductController::class, 'deleteProductVideo']);

        // Attributes
        Route::match(['get', 'post'], 'add-attributes/{id}', [ProductController::class, 'addAttributes']);
        Route::post('edit-attributes/{id}', [ProductController::class, 'editAttributes']);
        Route::post('update-attribute-status', [ProductController::class, 'updateAttributeStatus']);
        Route::get('delete-attribute/{id}', [ProductController::class, 'deleteAttribute']);

        // Images
        Route::match(['get', 'post'], 'add-images/{id}', [ProductController::class, 'addImages']);
        Route::post('update-image-status', [ProductController::class, 'updateImageStatus']);
        Route::get('delete-image/{id}', [ProductController::class, 'deleteImage']);

        // Banners
        Route::get('banners', [BannersController::class, 'banners']);
        Route::match(['get', 'post'], 'add-edit-banners/{id?}', [BannersController::class, 'addEditBanner']);
        Route::post('update-banner-status', [BannersController::class, 'updateBannerStatus']);
        Route::get('delete-banner/{id}', [BannersController::class, 'deleteBanner']);

        // Coupons
        Route::get('coupons', [CouponsController::class, 'coupons']);
        Route::post('update-coupon-status', [CouponsController::class, 'updateCouponStatus']);
        Route::match(['get','post'], 'add-edit-coupon/{id?}', [CouponsController::class, 'addEditCoupon']);
        Route::get('delete-coupon/{id}', [CouponsController::class, 'deleteCoupon']);

        // Orders
        Route::get('orders', [OrdersController::class, 'orders']);
        Route::get('orders/{id}', [OrdersController::class, 'orderDetails']);
        Route::post('update-order-status', [OrdersController::class, 'updateOrderStatus']);
        Route::get('view-order-invoice/{id}', [OrdersController::class, 'viewOrderInvoice']);
    });

});

Route::namespace('Front')->group(function() {
    Route::get('/', [FrontIndexController::class, 'index']);
// Get Category url's
    $catUrls = Category::select('url')->where('status', 1)->pluck('url')->toArray();
    foreach($catUrls as $url) {
        Route::get('/'.$url, [FrontProductsController::class, 'listing']);
    }
// Product Details Route
    Route::get('/product/{id}', [FrontProductsController::class, 'detail']);

// Get Product Attributes Price
    Route::post('/get-product-price', [FrontProductsController::class, 'getProductPrice']);

// Add to Cart Route
    Route::post('/add-to-cart', [FrontProductsController::class, 'addToCart']);

// Shopping Cart Route
    Route::get('/cart', [FrontProductsController::class, 'cart']);

// Update Cart Item Quantity
    Route::post('/update-cart-item-qty', [FrontProductsController::class, 'updateCartItemQty']);

// Delete Cart Item
    Route::post('/delete-cart-item', [FrontProductsController::class, 'deleteCartItem']);

// Login / Register Route
    Route::get('/login-register', [UsersController::class, 'loginRegister']);
    Route::post('/login', [UsersController::class, 'loginUser']);
    Route::post('/register', [UsersController::class, 'registerUser']);
    Route::match(['get','post'], '/check-email', [UsersController::class, 'checkEmail']);
    Route::get('/logout', [UsersController::class, 'logoutUser']);

// Confirm Account
    Route::match(['GET', 'POST'], '/confirm/{code}', [UsersController::class, 'confirmAccount']);

// Forgot Password Route
    Route::match(['GET', 'POST'], '/forgot-password', [UsersController::class, 'forgotPassword']);

    Route::group(['middleware'=>['auth']], function() {

        // Users Account
        Route::match(['GET', 'POST'], '/account', [UsersController::class, 'account']);

        // User Orders
        Route::get('/orders', [FrontOrdersController::class, 'orders']);

        // User Order Detail
        Route::get('/orders/{id}', [FrontOrdersController::class, 'orderDetails']);

        // Check user current password
        Route::post('/check-user-pwd', [UsersController::class, 'chkUserPassword']);

        // Update User Password
        Route::post('/update-user-pwd', [UsersController::class, 'updateUserPassword']);

        // Apply Coupon
        Route::post('/apply-coupon', [FrontProductsController::class, 'applyCoupon']);

        // Checkout
        Route::match(['GET','POST'], '/checkout', [FrontProductsController::class, 'checkout']);

        // Add/Edit Delivery Address
        Route::match(['GET', 'POST'], '/add-edit-delivery-address/{id?}', [FrontProductsController::class, 'addEditDeliveryAddress']);

        // Delete Delivery Address
        Route::get('/delete-delivery-address/{id}', [FrontProductsController::class, 'deleteDeliveryAddress']);

        // Thanks
        Route::get('/thanks', [FrontProductsController::class, 'thanks']);
    });
});
