<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


//Thêm controller vào nè ======================================================================================
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\EditingController;
use App\Http\Controllers\OrderController;

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


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//Xác nhận email khi đăng ký
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//Kết thúc xác nhận email

Route::get('/admin/login', function() {

    return view('admin.login');
});

Route::post('/admin/login', [AdminController::class, 'loginPost'])->name('admin.loginPost');

//Controller thực chất chỉ là 1 class mà thôi, AdminController::class => định nghĩa lại nó là 1 class
//chạy vào cái hàm loginPost trong AdminController

//Tạo route sau khi login thành công
// Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin');

//Tạo route logout
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware(['employee'])->group(function ()
{
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    //Danh sach

      Route::get('/admin/listing/{model}', [ListingController::class, 'index'])->name('listing.index');
      Route::post('/admin/listing/{model}', [ListingController::class, 'index'])->name('listing.index');

    //Nhập, xuất hàng
    Route::get('/admin/import/{model}', [AdminController::class, 'import'])->name('admin.import');
    Route::get('/admin/importOrder/{model}', [OrderController::class, 'create'])->name('orderImport.create');
    Route::post('/admin/importOrder/{model}/{n}', [OrderController::class, 'postCreate'])->name('orderImport.postCreate');
    Route::get('/admin/importOrderConfirm/{model}/{id}', [OrderController::class, 'getConfirm'])->name('orderImport.getConfirm');
    Route::post('/admin/importOrderConfirm/{model}/{id}', [OrderController::class, 'postConfirm'])->name('orderImport.postConfirm');

    //Thêm, sửa, chi tiết
    Route::get('/admin/editing/{model}', [EditingController::class, 'create'])->name('editing.create');
    Route::post('/admin/editing/{model}', [EditingController::class, 'postCreate'])->name('editing.postCreate');

    Route::get('/admin/detail/{model}/{id}', [EditingController::class, 'getDetail'])->name('editing.getDetail');

    //Danh sách sản phẩm thuộc nhà cung cấp
    Route::get('/admin/listing-product/{id}', [ListingController::class, 'listingProduct'])->name('listing.product');
    Route::post('/admin/listing-product/{id}', [ListingController::class, 'listingProduct'])->name('listing.product');

    //Danh sách chi tiết sản phẩm
    Route::get('/admin/listing-detail-product/{id}', [ListingController::class, 'listingDetailProduct'])->name('listingdetail.product');
    Route::post('/admin/listing-detail-product/{id}', [ListingController::class, 'listingDetailProduct'])->name('listingdetail.product');
    
    //Danh sách chi tiết
    // Route::get('/admin/listing-detail-product', [ListingController::class, 'listingDetailProduct'])->name('listingdetail.product');
    //Route::post('/admin/listing-detail-product/{id}', [ListingController::class, 'listingDetailProduct'])->name('listingdetail.product');

    //Danh sách sản phẩm thuộc đơn hàng
    Route::get('/admin/orderDetail/{model}/{id}', [OrderController::class, 'getList'])->name('orderImport.getlist');

    //Thống kê
    Route::get('/admin/statistics/{n}', [AdminController::class, 'statistics'])->name('admin.statistics');

    //Xuất file pdf
    Route::get('/admin/prints/{n}', [AdminController::class, 'prints'])->name('admin.prints');

    //chi tiết sản phẩm
});

Route::middleware(['admin'])->group(function ()
{
    //sửa, xóa
    Route::post('/admin/editing/{model}/{id}', [EditingController::class, 'postEdit'])->name('editing.postEdit');
    Route::get('/admin/editing/{model}/{id}', [EditingController::class, 'getEdit'])->name('editing.getEdit');

    Route::get('/admin/delete/{model}/{id}', [EditingController::class, 'delete'])->name('editing.delete');
});