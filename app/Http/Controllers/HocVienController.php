<?php

namespace App\Http\Controllers;

use App\Mail\HocVienQuenMatKhau;
use App\Models\HocVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
            'message'  =>   'Vui Lòng Đợi Duyệt Tài Khoản',
            'status'   =>   true
        ]);
    }
    public function dangNhap(Request $request)
    {
        $check = Auth::guard('hoc_vien')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if ($check) {
            $user = Auth::guard('hoc_vien')->user();
            if ($user->is_duyet == 1) {
                return response()->json([
                    'message'  =>   'Đăng Nhập Thành Công.',
                    'status'   =>   true,
                    'chia_khoa' =>   $user->createToken('ma_so_chia_khoa_hoc_vien')->plainTextToken,
                    'ten_hoc_vien' =>   $user->ho_ten
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
        $data = HocVien::get();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function kiemTraChiaKhoa()
    {
        $check = $this->isUserHocVien();
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
                'message' => "Đã Đăng Xuất Tất Cả Thiết Bị Thành Công"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Vui Lòng Đăng Nhập"
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
            HocVien::where('id', $check->id)->update([
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
            HocVien::where('id', $check->id)->update([
                'password'             => bcrypt($request->password),
            ]);
            return response()->json([
                'status' => true,
                'message' => "Cập Nhật Mật Khẩu Thành Công"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có Lỗi Xảy Ra"
            ]);
        }
    }
    public function actionQuenmatKhau(Request $request)
    {
        $check = HocVien::where('email', $request->email)->first();
        if ($check) {
            $check->hash_reset = Str::uuid();
            $check->save();
            Mail::to($request->email)->send(new HocVienQuenMatKhau($check->hash_reset, $check->ho_ten));
            return response()->json([
                'status' => true,
                'message' => "Kiểm Tra Email"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có Lỗi Xảy Ra"
            ]);
        }
    }
    public function actionLayLaiMatKhau($hash_reset, Request $request)
    {
        $check = HocVien::where('hash_reset', $hash_reset)->first();
        if ($check) {
            $check->password = bcrypt($request->password);
            $check->hash_reset = null;
            $check->save();
            return response()->json([
                'status' => true,
                'message' => "Mật Khẩu Đã Được Đổi Thành Công"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có Lỗi Xảy Ra"
            ]);
        }
    }
    public function doiTrangThai(Request $request)
    {

        $hoc_vien = HocVien::where('id', $request->id)->first();

        if ($hoc_vien) {
            if ($hoc_vien->is_active == 0) {
                $hoc_vien->is_active = 1;
                $hoc_vien->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đã Kích Hoạt Tài Khoản Thành Công"
                ]);
            } else if ($hoc_vien->is_active == 1) {
                $hoc_vien->is_active = 2;
                $hoc_vien->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đã Khóa Tài Khoản Thành Công"
                ]);
            } else if($hoc_vien->is_active == 2) {
                $hoc_vien->is_active = 1;
                $hoc_vien->save();

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
