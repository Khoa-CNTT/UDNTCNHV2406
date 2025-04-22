<?php

namespace App\Http\Controllers;

use App\Models\ToChucCapChungChi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ToChucCapChungChiController extends Controller
{
    public function dangKy(Request $request)
    {
        ToChucCapChungChi::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'ten_to_chuc' => $request->ten_to_chuc,
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
        $check = Auth::guard('to_chuc_cap_chung_chi')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if ($check) {
            $user = Auth::guard('to_chuc_cap_chung_chi')->user();
            if ($user->is_duyet == 1) {
                return response()->json([
                    'message'  =>   'Đăng Nhập Thành Công.',
                    'status'   =>   true,
                    'chia_khoa' =>   $user->createToken('ma_so_chia_khoa_to_chuc')->plainTextToken,
                    'ten_to_chuc' =>   $user->ho_ten
                ]);
            } else if ($user->is_duyet == 0) {
                return response()->json([
                    'message'  =>   'Vui Lòng Đợi Duyệt Tài Khoản',
                    'status'   =>   false
                ]);
            } else if($user->is_duyet == 2) {
                return response()->json([
                    'message'  =>   'Tài Khoản Đã Bị Khóa',
                    'status'   =>   false,
                ]);
            }
        }else{
            return response()->json([
                'message'  =>   'Sai Thông Tin Đăng Nhập.',
                'status'   =>   false,
            ]);
        }
    }
    public function getData()
    {
        $data = ToChucCapChungChi::select()->get();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function kiemTraChiaKhoa()
    {
        $check = $this->isUserToChucCapChungChi();
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
    public function dangXuat()
    {
        $check = Auth::guard('sanctum')->user();
        if ($check) {
            DB::table('personal_access_tokens')
                ->where('id', $check->currentAccessToken()->id)->delete();

            return response()->json([
                'status' => true,
                'message' => "Đã đăng xuất thiết bị này thành công"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Vui lòng đăng nhập"
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
            ToChucCapChungChi::where('id', $check->id)->update([
                'email' => $request->email,
                'ten_to_chuc' => $request->ten_to_chuc,
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
                'status' => false,
                'message' => "Có Lỗi Xảy Ra"
            ]);
        }
    }
    public function updateMatKhau(Request $request)
    {
        $check = Auth::guard('sanctum')->user();
        if ($check) {
            $doi = ToChucCapChungChi::where('id', $check->id)->first();
            if (Hash::check($request->password, $doi->password)) {
                $doi->update([
                    'password' => bcrypt($request->update_password),
                ]);
                return response()->json([
                    'status' => true,
                    'message' => "Đổi Mật Khẩu Thành Công"
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Mật Khẩu Hiện Cũ Sai"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có Lỗi Xảy Ra"
            ]);
        }
    }
    public function doiTrangThai(Request $request)
    {

        $to_chuc = ToChucCapChungChi::where('id', $request->id)->first();

        if ($to_chuc) {
            if ($to_chuc->is_active == 0) {
                $to_chuc->is_active = 1;
                $to_chuc->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đã Kích Hoạt Tài Khoản Thành Công"
                ]);
            } else if ($to_chuc->is_active == 1) {
                $to_chuc->is_active = 2;
                $to_chuc->save();
                return response()->json([
                    'status' => true,
                    'message' => "Đã Khóa Tài Khoản Thành Công"
                ]);
            } else if($to_chuc->is_active == 2){
                $to_chuc->is_active = 1;
                $to_chuc->save();

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
