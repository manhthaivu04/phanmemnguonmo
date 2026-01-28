<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Lấy tuổi từ Session
    $tuoi = session('tuoi');

    // Kiểm tra logic
    if (!$tuoi || !is_numeric($tuoi) || $tuoi < 18) {
    
        return response("Không được phép truy cập (Tuổi: " . ($tuoi ?? 'Chưa nhập') . ")", 403);
    }


    return $next($request);
}
}