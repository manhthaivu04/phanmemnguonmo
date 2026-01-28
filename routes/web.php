<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController; 

// 1. Route Home "/"
Route::get('/', function () {
    return view('home');
})->name('home');


// Gom nhóm Route Product
Route::prefix('product')->group(function () {

    // 2. Route "/product": Danh sách sản phẩm
    Route::get('/', function () {
        return view('product.index');
    })->name('product.index');

    // 3. Route "/product/add": Form thêm mới
    Route::get('/add', function () {
        return view('product.add');
    })->name('product.add');

    // 4. Route "/product/{id}": Chi tiết sản phẩm
    Route::get('/{id?}', function ($id = '123') {
        return "Chi tiết sản phẩm có ID: " . $id;
    })->where('id', '[a-zA-Z0-9]+')->name('product.detail');
});


// 5. Demo gọi route
Route::get('/demo-route', function () {
    $url = route('product.add');
    return "Đây là ví dụ gọi route theo tên. Đường dẫn đến trang thêm sản phẩm là: " . $url;
});


// 6. Route Sinh viên
Route::get('/sinhvien/{name?}/{mssv?}', function ($name = 'Luong Xuan Hieu', $mssv = '123456') {
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

// 8. Fallback Route (LUÔN ĐỂ Ở CUỐI CÙNG)
Route::fallback(function () {
    return view('error.404');
});