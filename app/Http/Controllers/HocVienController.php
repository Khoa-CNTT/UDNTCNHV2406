<?php

namespace App\Http\Controllers;

use App\Models\HocVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HocVienController extends Controller
{
    public function dangKy(Request $request)
    {
        HocVien::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'ho_ten' => $request->ho_ten,
            'ngay_sinh' => $request->ngay_sinh,
            'gioi_tinh' => $request->gioi_tinh,
            'so_cccd' => $request->so_cccd,
            'sdt' => $request->sdt,
            'dia_chi' => $request->dia_chi,
            'is_duyet' => 0,
        ]);
        return response()->json([
            'message'  =>   'Vui lòng đợi duyệt tài khoản, mời bạn đang nhập lại sau.',
            'status'   =>   true
        ]);
    }
    public function dangNhap(Request $request)
    {
        $check = Auth::guard('hoc_vien')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);
        if ($check) {
            $user = Auth::guard('hoc_vien')->user();
            return response()->json([
                'status' => true,
                'message' => "Đăng Nhập Thành Công",
                'chia_khoa' => $user->createToken('ma_so_bi_mat')->plainTextToken,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Sai Tài Khoản Hoặc Mật Khẩu",
            ]);
        }
    }
    public function getData()
    {
        $dulieu = HocVien::get();
        return response()->json([
            'data' => $dulieu
        ]);
    }
}
