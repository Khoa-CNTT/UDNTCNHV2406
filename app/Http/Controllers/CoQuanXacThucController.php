<?php

namespace App\Http\Controllers;

use App\Models\CoQuanXacThuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoQuanXacThucController extends Controller
{
    public function dangKy(Request $request)
    {
        CoQuanXacThuc::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'ten_co_quan' => $request->ten_co_quan,
            'hotline' => $request->hotline,
            'dia_chi' => $request->dia_chi,
            'ho_ten_nguoi_dai_dien' => $request->ho_ten_nguoi_dai_dien,
            'so_cccd' => $request->so_cccd,
            'sdt_nguoi_dai_dien' => $request->sdt_nguoi_dai_dien,
            'email_nguoi_dai_dien' => $request->email_nguoi_dai_dien,
            'is_duyet' => 0,
        ]);
        return response()->json([
            'message'  =>   'Vui lòng đợi duyệt tài khoản, mời bạn đang nhập lại sau.',
            'status'   =>   true
        ]);
    }
    public function dangNhap(Request $request)
    {
        $check = Auth::guard('co_quan_xac_thuc')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if ($check) {
            $user = Auth::guard('co_quan_xac_thuc')->user();
            return response()->json([
                'message'  =>   'Đăng nhập thành công.',
                'status'   =>   true,
                'chia_khoa' =>   $user->createToken('ma_so_chia_khoa_co_quan')->plainTextToken,
                'ten_co_quan' =>   $user->ten_co_quan
            ]);
        } else {
            return response()->json([
                'message'  =>   'Sai thông tin đăng nhập.',
                'status'   =>   false,
            ]);
        }
    }
    public function getData()
    {
        $data = CoQuanXacThuc::select()->get();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function kiemTraChiaKhoa()
    {
        $check = $this->isUserCoQuanXacThuc();
        if ($check) {
            return response()->json([
                'status'   =>   true,
                'message'  =>   '',
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
            CoQuanXacThuc::where('id', $check->id)->update([
                'email' => $request->email,
                'ten_co_quan' => $request->ten_co_quan,
                'hotline' => $request->hotline,
                'dia_chi' => $request->dia_chi,
                'ho_ten_nguoi_dai_dien' => $request->ho_ten_nguoi_dai_dien,
                'so_cccd' => $request->so_cccd,
                'sdt_nguoi_dai_dien' => $request->sdt_nguoi_dai_dien,
                'email_nguoi_dai_dien' => $request->email_nguoi_dai_dien,
            ]);
            return response()->json([
                'status' => true,
                'message' => "Cập Nhật Thông Tin Thành Công"
            ]);
        } else {
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
            CoQuanXacThuc::where('id', $check->id)->update([
                'password'             => bcrypt($request->password),
            ]);
            return response()->json([
                'status' => true,
                'message' => "Cập Nhật Mật Khẩu Thành Công"
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Có Lỗi Xảy Ra"
            ]);
        }
    }
    public function getHocdoiTrangThaiVien(Request $request)
    {

        $co_quan = CoQuanXacThuc::where('id', $request->id)->first();

        if ($co_quan) {
            if ($co_quan->is_active == 0) {
                $co_quan->is_active = 1;
                $co_quan->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đã Kích Hoạt Tài Khoản Thành Công"
                ]);
            } else if ($co_quan->is_active == 1) {
                $co_quan->is_active = 2;
                $co_quan->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đã Khóa Tài Khoản Thành Công"
                ]);
            } else {
                $co_quan->is_active = 1;
                $co_quan->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đã Mở Khóa Tài Khoản Thành Công"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có Lỗi Xảy Ra"
            ]);
        }
    }
}
