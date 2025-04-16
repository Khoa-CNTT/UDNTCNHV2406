<?php

namespace App\Http\Controllers;

use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dangKy(Request $request)
    {
        Admin::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'ho_ten' => $request->ho_ten,
            'ngay_sinh' => $request->ngay_sinh,
            'gioi_tinh' => $request->gioi_tinh,
            'so_cccd' => $request->so_cccd,
            'sdt' => $request->sdt,
            'dia_chi' => $request->dia_chi,
            'id_chuc_vu' => $request->id_chuc_vu,
            'is_duyet' => 0,
        ]);
        return response()->json([
            'message'  =>   'Đăng ký tài khoản thành công.',
            'status'   =>   true
        ]);
    }
    public function dangNhap(Request $request)
    {
        $check = Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if ($check) {
            $user = Auth::guard('admin')->user();
            return response()->json([
                'message'  =>   'Đăng nhập thành công.',
                'status'   =>   true,
                'chia_khoa' =>   $user->createToken('ma_so_chia_khoa_admin')->plainTextToken,
                'ten_admin' =>   $user->email
            ]);
        } else {
            return response()->json([
                'message'  =>   'Sai thông tin đăng nhập.',
                'status'   =>   false,
            ]);
        }
    }
    public function kiemTraChiaKhoa()
    {
        $check = $this->isUserAdmin();
        if ($check) {
            return response()->json([
                'status'   =>   true,
                'message'  =>   'aaa',
            ]);
        } else {
            return response()->json([
                'status'   =>   false,
                'message'  =>   'Yêu Cầu Đăng Nhập',
            ]);
        }
    }
    public function dangXuatAll()
    {
        $check = Auth::guard('sanctum')->user();
        if ($check) {
            $ds_token = $check->tokens;
            foreach ($ds_token as $k => $v) {
                $v->delete();
            }

            return response()->json([
                'status' => true,
                'message' => "Đã đăng xuất tất cả thiết bị này thành công"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Vui lòng đăng nhập"
            ]);
        }
    }
    public function Profile()
    {
        $data = Auth::guard('sanctum')->user();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function updateProfile(Request $request)
    {
        $check = Auth::guard('sanctum')->user();
        if ($check) {
            Admin::where('id', $check->id)->update([
                'email' => $request->email,
                'ho_ten' => $request->ho_ten,
                'ngay_sinh' => $request->ngay_sinh,
                'gioi_tinh' => $request->gioi_tinh,
                'so_cccd' => $request->so_cccd,
                'sdt' => $request->sdt,
                'dia_chi' => $request->dia_chi,
            ]);
            return response()->json([
                'status' => true,
                'message' => "Cập Nhật Thông Tin Thành Công"
            ]);
        }else{
            return response()->json([
                'status' => true,
                'message' => "Có Lỗi Xảy Ra"
            ]);
        }
    }
    public function updateMatKhau(Request $request)
    {
        $check = Auth::guard('sanctum')->user();
        if ($check) {
            Admin::where('id', $check->id)->update([
                'password'             => bcrypt($request->password),
            ]);
            return response()->json([
                'status' => true,
                'message' => "Cập Nhật Mật Khẩu Thành Công"
            ]);
        }else{
            return response()->json([
                'status' => true,
                'message' => "Có Lỗi Xảy Ra"
            ]);
        }
    }
}
