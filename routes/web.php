<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CMSPageController;
use App\Http\Controllers\Admin\DashboradController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\PushNotificationController;
use App\Http\Controllers\Admin\ManageFormsController;
use App\Http\Controllers\Admin\DeliveryChargesController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\Admin\StoreLocationController;
use App\Http\Controllers\Subadmin\DashboardController;
use App\Http\Controllers\Subadmin\OrderManageController;
use App\Http\Controllers\Subadmin\ProfileController;
use App\Http\Controllers\Admin\DeleteUserAccountController;
use App\Http\Controllers\PHPMailerController;
use App\Http\Controllers\Admin\MinimumOrderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\VendorController;

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
    // return redirect()->route('admin');
    return view('frontend/index');
});

Route::get('/admin', function () {
    return redirect()->route('admin');
});

Route::get('/admin/login', function () {
    return redirect()->route('admin');
});

Route::get('/login', function () {
    return redirect()->route('admin');
});

Route::get('/login', [AdminController::class, 'index'])->name('admin');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/account-delete', [DeleteUserAccountController::class, 'deleteAccountView'])->name('account-delete');
Route::post('/send-otp', [DeleteUserAccountController::class, 'deleteAccountSendOtp'])->name('send.otp');
Route::post('/verify-otp', [DeleteUserAccountController::class, 'verifyOtp'])->name('verify.otp');
// Route::post('/store', [HomeController::class, 'store'])->name('store'); 

// Route::get('/beforePostCreate', [DefaultApiController::class,'beforePostCreate']);

// Auth::routes();
Route::group(['prefix' => 'subadmin', 'middleware' => ['subadmin']], function () {
    Route::get('change-password', [DashboardController::class, 'changePassword'])->name('change-password');
    Route::post('change-password', [DashboardController::class, 'changePasswordUpdate'])->name('change-password.update');
    Route::get('/dashboard-page', [DashboardController::class, 'dashboard'])->name('dashboard-page');

    //orders
    Route::get('/order-manage/list', [OrderManageController::class, 'index'])->name('order-manage.index');
    Route::get('/order-manage/show/{id}', [OrderManageController::class, 'show'])->name('order-manage.show');
    Route::post('/order-manage-manage/status/{id}', [OrderManageController::class, 'status'])->name('order-manage.status');
    Route::get('/orders/export', [OrderManageController::class, 'export'])->name('orders.export');

    //profile
    Route::get('my-profile', [ProfileController::class, 'myProfile'])->name('my-profile');
    Route::post('my-profile/update', [ProfileController::class, 'updateProfile'])->name('my-profile.update');
});

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {

    Route::get('changepassword', [DashboradController::class, 'changePassword'])->name('changepassword');
    Route::post('changepassword', [DashboradController::class, 'changePasswordUpdate'])->name('changepassword.update');
    Route::get('/dashboard', [DashboradController::class, 'dashboard'])->name('dashboard');
    Route::get('orders/category/{id}', [DashboradController::class, 'getOrdersByCategory'])->name('orders.category');
    Route::get('/user/detail', [AdminController::class, 'show'])->name('user.detail');
    Route::get('/profile/{id?}', [AdminController::class, 'profile'])->name('admin.profile');
    // cms pages
    Route::get('/cms/pages/list', [CMSPageController::class, 'index'])->name('cms.index');
    Route::get('/cms/page/create', [CMSPageController::class, 'create'])->name('cms.create');
    Route::post('/cms/page/store', [CMSPageController::class, 'store'])->name('cms.store');
    Route::get('/cms/page/{slug}', [CMSPageController::class, 'show'])->name('cms.show');
    Route::get('/cms/page/edit/{id}', [CMSPageController::class, 'edit'])->name('cms.edit');
    Route::post('/cms/page/update/{id}', [CMSPageController::class, 'update'])->name('cms.update');
    Route::any('/cms/page/destroy/{id}', [CMSPageController::class, 'destroy'])->name('cms.destroy');
    Route::any('/cms/page/status', [CMSPageController::class, 'status'])->name('cms.status');
    // users
    Route::get('/users/index', [UsersController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('user.create');
    Route::post('/users/store', [UsersController::class, 'store'])->name('user.store');
    Route::get('/users/show/{id}', [UsersController::class, 'show'])->name('user.show');
    Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
    Route::post('/users/update/{id}', [UsersController::class, 'update'])->name('user.update');
    Route::get('/users/export', [UsersController::class, 'getUserData'])->name('export.users');
    Route::post('/users/update-password/{id}', [UsersController::class, 'updatePassword'])->name('user.update.password');
    Route::any('/users/destroy/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
    Route::post('/users/switch/toggle', [UsersController::class, 'switchToggle'])->name('user.switch.toggle');
    Route::post('/book/switch/toggle', [UsersController::class, 'switchToggleBook'])->name('book.switch.toggle');

    // Vendor

    Route::get('/vendor/index', [VendorController::class, 'index'])->name('vendor.index');
    Route::get('/vendor/create', [VendorController::class, 'create'])->name('vendor.create');
    Route::post('/vendor/store', [VendorController::class, 'store'])->name('vendor.store');

    // category
    Route::get('/category/list', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::post('/category/status', [CategoryController::class, 'status'])->name('category.status');
    Route::get('/category/show/{id}', [CategoryController::class, 'show'])->name('category.show');
    Route::post('category/update-order', [CategoryController::class, 'updateOrder'])->name('category.updateOrder');


    // subcategory
    Route::get('/subcategory/list', [SubCategoryController::class, 'index'])->name('subcategory.index');
    Route::get('/subcategory/create', [SubCategoryController::class, 'create'])->name('subcategory.create');
    Route::post('/subcategory/store', [SubCategoryController::class, 'store'])->name('subcategory.store');
    Route::get('/subcategory/edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategory.edit');
    Route::post('/subcategory/update/{id}', [SubCategoryController::class, 'update'])->name('subcategory.update');
    Route::post('/subcategory/destroy/{id}', [SubCategoryController::class, 'destroy'])->name('subcategory.destroy');
    Route::post('/subcategory/status', [SubCategoryController::class, 'status'])->name('subcategory.status');
    Route::get('/subcategory/show/{id}', [SubCategoryController::class, 'show'])->name('subcategory.show');
    Route::post('subcategory/update-order', [SubCategoryController::class, 'updateOrder'])->name('subcategory.updateOrder');
    //product
    Route::get('/get-subcategories', [ProductController::class, 'getSubcategories'])->name('admin.getSubcategories');
    Route::post('/product/status', [ProductController::class, 'status'])->name('product.status');
    Route::get('/products-export', [ProductController::class, 'getProductData'])->name('products.export');
    Route::resource('product', ProductController::class);
    Route::post('product/update-order', [ProductController::class, 'updateOrder'])->name('product.updateOrder');

    // faq
    Route::get('/faq/list', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
    Route::post('/faq/store', [FaqController::class, 'store'])->name('faq.store');
    Route::get('/faq/{id}', [FaqController::class, 'show'])->name('faq.show');
    Route::get('/faq/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
    Route::post('/faq/update/{id}', [FaqController::class, 'update'])->name('faq.update');
    Route::any('/faq/destroy/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');
    Route::any('/faq/status', [FaqController::class, 'status'])->name('faq.status');

    //slider images
    Route::post('/slider/status', [SliderController::class, 'status'])->name('slider.status');
    Route::resource('sliders', SliderController::class);

    //orders
    Route::get('/order/list', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/show/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/order/status/{id}', [OrderController::class, 'status'])->name('order.status');
    Route::post('/role/assign/{id}', [OrderController::class, 'assignRole'])->name('order.assign-subadmin');
    Route::get('/export-orders', [OrderController::class, 'getOrderData'])->name('export-orders');
    Route::post('/order/destroy/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::post('/orders/mass-delete', [OrderController::class, 'massDelete'])->name('order.massDelete');
    Route::get('/orders/trashed', [OrderController::class, 'trashedItems'])->name('orders.trashed');
    Route::post('/orders/restore/{id}', [OrderController::class, 'restore'])->name('orders.restore');
    Route::post('/orders/delete/{id}', [OrderController::class, 'forceDelete'])->name('orders.delete');

    //contact us
    Route::get('/enquiry', [ContactUsController::class, 'index'])->name('enquiry.index');
    Route::get('/enquiry/{id}', [ContactUsController::class, 'show'])->name('enquiry.show');

    //push_notification
    Route::get('/push_notification/list', [PushNotificationController::class, 'index'])->name('push_notification.index');
    Route::get('/push_notification/create', [PushNotificationController::class, 'create'])->name('push_notification.create');
    Route::post('/push_notification/store', [PushNotificationController::class, 'store'])->name('push_notification.store');
    Route::get('/push_notification/{id}', [PushNotificationController::class, 'show'])->name('push_notification.show');
    Route::get('/push_notification/edit/{id}', [PushNotificationController::class, 'edit'])->name('push_notification.edit');
    Route::post('/push_notification/update/{id}', [PushNotificationController::class, 'update'])->name('push_notification.update');
    Route::any('/push_notification/destroy/{id}', [PushNotificationController::class, 'destroy'])->name('push_notification.destroy');
    Route::post('/send-push-notification/{id}', [PushNotificationController::class, 'sendPushNotification'])->name('send_push_notification');

    //manage forms
    Route::get('/manage_forms/list', [ManageFormsController::class, 'index'])->name('manage_forms.index');
    Route::get('/manage_forms/create', [ManageFormsController::class, 'create'])->name('manage_forms.create');
    Route::post('/manage_forms/store', [ManageFormsController::class, 'store'])->name('manage_forms.store');
    Route::get('/manage_forms/edit/{id}', [ManageFormsController::class, 'edit'])->name('manage_forms.edit');
    Route::post('/manage_forms/update/{id}', [ManageFormsController::class, 'update'])->name('manage_forms.update');
    Route::get('/manage_forms/show/{id}', [ManageFormsController::class, 'show'])->name('manage_forms.show');
    Route::post('/manage_forms/delete/{id}', [ManageFormsController::class, 'destroy'])->name('manage_forms.destroy');

    //delivery charges
    Route::get('/delivery_charges', [DeliveryChargesController::class, 'view'])->name('delivery_charges.view');
    Route::put('/delivery_charges/update', [DeliveryChargesController::class, 'updateDeliveryCharges'])->name('delivery_charges.update');

    //roles
    Route::resource('roles', RoleController::class);

    //subadmins
    Route::get('subadmins/create', [SubAdminController::class, 'create'])->name('subadmins.create');
    Route::post('subadmins', [SubAdminController::class, 'store'])->name('subadmins.store');
    Route::get('subadmins', [SubAdminController::class, 'index'])->name('subadmins.index');
    Route::get('subadmins/{id}/edit', [SubAdminController::class, 'edit'])->name('subadmins.edit');
    Route::put('subadmins/{id}', [SubAdminController::class, 'update'])->name('subadmins.update');
    Route::delete('subadmins/delete/{id}', [SubAdminController::class, 'destroy'])->name('subadmins.destroy');

    //store location
    Route::get('/store_location', [StoreLocationController::class, 'view'])->name('store_location.view');
    Route::put('/store_location/update', [StoreLocationController::class, 'updateStoreLocation'])->name('store_location.update');

    //Minimum order value
    Route::get('/min_order', [MinimumOrderController::class, 'index'])->name('min_order');
    Route::post('/min-order_add', [MinimumOrderController::class, 'add'])->name('min_order_add');

    // Coupons
    Route::get('/coupons/list', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupon.create');
    Route::post('/coupons/store', [CouponController::class, 'store'])->name('coupon.store');
    Route::get('/coupons/edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit');
    Route::put('/coupons/update/{id}', [CouponController::class, 'update'])->name('coupon.update');
    Route::get('/coupons/show/{id}', [CouponController::class, 'show'])->name('coupon.show');
    Route::post('/coupons/destroy/{id}', [CouponController::class, 'destroy'])->name('coupon.destroy');
    Route::post('/coupons/status', [CouponController::class, 'status'])->name('coupon.status');
});

Route::get('/{slug}', [CMSPageController::class, 'showPage'])->name('cms.page.show');
Route::get('/faqs', [FaqController::class, 'showFaq'])->name('faqs.page.show');

Route::post('/mail', [PHPMailerController::class, 'composeEmail']);
