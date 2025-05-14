<?php

namespace App\Http\Controllers;

use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\AdminQuenMatKhau;
use App\Models\ChiTietCapQuyen;
use App\Models\HocVien;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function getData()
    {
        $data = Admin::join('chuc_vus', 'admins.id_chuc_vu', 'chuc_vus.id')
            ->select('admins.*', 'chuc_vus.ten_chuc_vu')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function dangKy(Request $request)
    {
        $id_chuc_nang = 2;
        $user = $this->isUserAdmin();
        $checkQuyen = ChiTietCapQuyen::where('id_chuc_vu', $user->id_chuc_vu)->where('id_chuc_nang', $id_chuc_nang)->first();
        if (!$checkQuyen) {
            return response()->json([
                'message'  =>   'Bạn chưa được cấp quyền này',
                'status'   =>   false,
            ]);
        }

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
            'is_duyet' => 1,
        ]);
        return response()->json([
            'message'  =>   'Thêm Tài Khoản Thành Công.',
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
            if ($user->is_duyet == 1) {
                return response()->json([
                    'message'  =>   'Đăng Nhập Thành Công.',
                    'status'   =>   true,
                    'chia_khoa' =>   $user->createToken('ma_so_chia_khoa_admin')->plainTextToken,
                    'ten_admin' =>   $user->ho_ten
                ]);
            } else if ($user->is_duyet == 2) {
                return response()->json([
                    'message'  =>   'Tài Khoản Đã Bị Khóa',
                    'status'   =>   false,
                ]);
            }
        } else {
            return response()->json([
                'message'  =>   'Sai Thông Tin Đăng Nhập.',
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
            $doi = Admin::where('id', $check->id)->first();
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
    public function actionQuenmatKhau(Request $request)
    {
        $check = Admin::where('email', $request->email)->first();
        if ($check) {
            $check->hash_reset = Str::uuid();
            $check->save();
            Mail::to($request->email)->send(new AdminQuenMatKhau($check->hash_reset, $check->ho_ten));
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
        $check = Admin::where('hash_reset', $hash_reset)->first();
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
        $id_chuc_nang = 2;
        $user = $this->isUserAdmin();
        $checkQuyen = ChiTietCapQuyen::where('id_chuc_vu', $user->id_chuc_vu)->where('id_chuc_nang', $id_chuc_nang)->first();
        if (!$checkQuyen) {
            return response()->json([
                'message'  =>   'Bạn chưa được cấp quyền này',
                'status'   =>   false,
            ]);
        }

        $admin = Admin::where('id', $request->id)->first();

        if ($admin) {
            if ($admin->is_duyet == 0) {
                $admin->is_duyet = 1;
            } else {
                $admin->is_duyet = 0;
            }
            $admin->save();

            return response()->json([
                'status'    =>   true,
                'message'   =>   'Đã đổi trạng thái nhân viên ' . $admin->ho_ten . '!',
            ]);
        } else {
            return response()->json([
                'status'    =>   false,
                'message'   =>   'Không tìm được đại lý để cập nhật!'
            ]);
        }
    }

}
