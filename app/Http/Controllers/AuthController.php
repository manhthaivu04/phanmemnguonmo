<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // 1. Trả về view SignIn
    public function signin() {
        return view('signin');
    }

    // 2. Kiểm tra dữ liệu
    public function checkSignIn(Request $request) {
        // Lấy dữ liệu từ form
        $username = $request->input('username');
        $password = $request->input('password');
        $repass = $request->input('repass');
        $mssv = $request->input('mssv');
        $lop = $request->input('lop');
        $gioitinh = $request->input('gioitinh');

        // --- CẤU HÌNH THÔNG TIN SINH VIÊN ---
        $myMSSV = "123456"; 
        $myLop = "67PM1";
  
        // 1. Password phải trùng Repass
        // 2. MSSV và Lớp phải trùng với thông tin sinh viên làm bài 
        if ($password === $repass && $mssv === $myMSSV && $lop === $myLop) {
            return "Đăng ký thành công!";
        } else {
            return "Đăng ký thất bại: Thông tin sai hoặc mật khẩu không khớp.";
        }
    }
}