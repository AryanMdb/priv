<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\locationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(array('prefix' => '/v1', 'throttle' => 'none'), function () {
    //auth controller
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('/login', [AuthController::class, 'login']);

    //user controller
    Route::get('/get-faqs', [UserController::class, 'getFaqs']);
    Route::get('/get-cms-pages', [UserController::class, 'getCMSPages']);
    Route::get('/get-sliders', [UserController::class, 'getSliders']);
    Route::post('/contact-us', [UserController::class, 'contactUs']);
    Route::get('/categories', [ProductController::class, 'getCategories']);
    Route::get('/subcategories', [ProductController::class, 'getSubCategories']);
    Route::get('/products', [ProductController::class, 'getProducts']);
    Route::get('/get-store-location', action: [locationController::class, 'stroeLocation']);

    Route::middleware(['jwt'])->group(function () {
        //auth controller
        Route::post('/logout', [AuthController::class, 'logout']);

        //user controller
        Route::post('/complete-profile', [UserController::class, 'completeProfile']);
        Route::post('/update-user', [UserController::class, 'updateUser']);
        Route::post('/delete-user', [UserController::class, 'deleteUser']);
        Route::get('/my-profile-data', [UserController::class, 'getMyProfileData']);
        Route::post('/insert-update/profile-image', [UserController::class, 'insertOrUpdateProfileImage']);
        Route::get('/notifications', [UserController::class, 'getNotifications']);
        Route::get('/notifications-count', [UserController::class, 'notificationsCount']);
        Route::get('/store-location', [UserController::class, 'getStoreLocation']);

        //product controller
        Route::post('/add-to-cart', [ProductController::class, 'addToCart']);
        

        Route::get('/add-to-cart/count', [ProductController::class, 'addToCartCount']);
        Route::get('/get-add-to-cart/products', [ProductController::class, 'getAddToCartProducts']);
        Route::get('/get-add-to-cart/products/{location_id}/{distance}', [ProductController::class, 'getAddToCartProducts']);
        

        Route::delete('/cart/remove-item/{id}', [ProductController::class, 'removeCartItem']);
        Route::delete('/remove-cart/{id}', [ProductController::class, 'removeCart']);
        Route::post('/place-order', [ProductController::class, 'placeOrder']);
        Route::post('/increase-decrease-cart-item/{id}', [ProductController::class, 'increaseDecreaseCartItemNo']);
        Route::get('/my-orders', [ProductController::class, 'myOrders']);
        Route::get('/get-order-details/{id}', [ProductController::class, 'getOrderDetails']);
        Route::get('/dynamic-form-fields', [ProductController::class, 'getDynamicFormFields']);
        Route::get('/search-filter', [ProductController::class, 'searchFilter']);
        Route::get('/delivery-charges', [ProductController::class, 'getDeliveryCharges']);
        Route::get('/get-coupons', [ProductController::class, 'coupons']);
        Route::post('/apply-coupon', [ProductController::class, 'applyCoupon']);

        Route::get('/distance', [ProductController::class, 'distance']);

        Route::get('/product-detail/{id}', [ProductController::class, 'productDetail']);

        //Location controller
        Route::get('/location', [locationController::class, 'getLocations']);
        Route::post('/create_location', [locationController::class, 'createLocation']);
        Route::post('/delete_location/{id}', [locationController::class, 'deleteLocation']);
        Route::get('/edit_location/{id}', [locationController::class, 'editLocation']);
        Route::post('/update_location/{id}', [locationController::class, 'updateLocation']);


    });
});
