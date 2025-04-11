<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dangNhap(Request $request)
    {
        $check = Auth::guard('admin')->attempt([
            'email'     =>  $request->email,
            'password'  =>  $request->password
        ]);
        if ($check) {
            $user = Auth::guard('admin')->user();
            return response()->json([
                'status' => true,
                'message' => "Đăng Nhập Thành Công",
                'chia_khoa' => $user->createToken('ma_so_bi_mat')->plainTextToken,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Sai Tài Khoản Hoặc Mật Khẩu"
            ]);
        }
    }
    public function dangKy(Request $request)
    {
        Admin::create([
            'email'                 =>  $request->email,
            'password'              =>  bcrypt($request->password),
        ]);
        return response()->json([
            'message'  =>   'Đăng ký tài khoản thành công.',
            'status'   =>   true
        ]);
    }
}
