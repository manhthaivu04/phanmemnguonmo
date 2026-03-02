<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\ProductController;

// 1. Route Home "/"
Route::get('/', function () {
    return view('home');
})->name('home');


// QUẢN LÝ SẢN PHẨM (PRODUCT) 
Route::prefix('product')->group(function () {
    // Hiển thị danh sách
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    
    // Form thêm mới
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    
    // Xử lý lưu
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    
    // Form sửa
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    
    // Xử lý cập nhật
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
    
    // Xóa mềm
    Route::get('/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
});


// 5. Demo gọi route
Route::get('/demo-route', function () {
    // Lưu ý: route 'product.add' cũ đã đổi thành 'product.create' ở trên
    $url = route('product.create'); 
    return "Đây là ví dụ gọi route theo tên. Đường dẫn đến trang thêm sản phẩm là: " . $url;
});


// 6. Route Sinh viên
Route::get('/sinhvien/{name?}/{mssv?}', function ($name = 'Luong Xuan Hieu', $mssv = '123456') {
    // Lưu ý: Đảm bảo bạn có file view 'product.sinhvien' hoặc sửa lại đường dẫn view cho đúng
    return view('product.sinhvien', [
        'name' => $name,
        'mssv' => $mssv
    ]);
});


// 7. Route Bàn cờ vua
Route::get('/banco/{n}', function ($n) {
    return view('banco', ['n' => $n]);
});


// --- COMMIT 1: Xử lý Đăng ký (SignIn) ---
Route::get('/signin', [AuthController::class, 'signin'])->name('auth.signin');
Route::post('/check-signin', [AuthController::class, 'checkSignIn'])->name('auth.check');

// --- COMMIT 2: Middleware kiểm tra tuổi ---
// Route nhập tuổi
Route::get('/nhap-tuoi', function () {
    return view('nhaptuoi');
});

// Route lưu tuổi vào Session
Route::post('/luu-tuoi', function (Request $request) {
    session(['tuoi' => $request->tuoi]);
    return "Đã lưu tuổi: " . $request->tuoi . ". <a href='/admin'>Vào trang Admin (Cần >= 18)</a>";
});

// Route Admin 
Route::middleware(['check.age'])->group(function () {
    Route::get('/admin', function () {
        return "Chào mừng bạn đến trang Admin! (Bạn đã đủ 18 tuổi)";
    });
});

// QUẢN LÝ DANH MỤC (CATEGORY)
Route::prefix('category')->group(function () {
    // Hiển thị danh sách
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    
    // Form thêm mới
    Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
    
    // Xử lý lưu dữ liệu
    Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
    
    // Form chỉnh sửa (cần ID)
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    
    // Xử lý cập nhật (cần ID)
    Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    
    // Xóa mềm (cần ID)
    Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
});


// 8. Fallback Route
Route::fallback(function () {
    return view('error.404');
});