<?php

namespace App\Http\Controllers;

use App\Models\ChiTietCapQuyen;
use App\Models\ChucVu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    public function getDataChucVu()
    {
        $id_chuc_nang = 1;
        $user = $this->isUserAdmin();
        $checkQuyen = ChiTietCapQuyen::where('id_chuc_vu', $user->id_chuc_vu)->where('id_chuc_nang', $id_chuc_nang)->first();
        if (!$checkQuyen) {
            return response()->json([
                'message'  =>   'Bạn chưa được cấp quyền này',
                'status'   =>   false,
            ]);
        }

        $data = ChucVu::select()->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function createDataChucVu(Request $request)
    {
        $id_chuc_nang = 1;
        $user = $this->isUserAdmin();
        $checkQuyen = ChiTietCapQuyen::where('id_chuc_vu', $user->id_chuc_vu)->where('id_chuc_nang', $id_chuc_nang)->first();
        if (!$checkQuyen) {
            return response()->json([
                'message'  =>   'Bạn chưa được cấp quyền này',
                'status'   =>   false,
            ]);
        }

        ChucVu::create([
            'ten_chuc_vu' => $request->ten_chuc_vu,
        ]);
        return response()->json([
            'message'  =>   'Thêm Chức Vụ Thành Công.',
            'status'   =>   true
        ]);
    }

    public function deleteChucVu($id)
    {
        $id_chuc_nang = 1;
        $user = $this->isUserAdmin();
        $checkQuyen = ChiTietCapQuyen::where('id_chuc_vu', $user->id_chuc_vu)->where('id_chuc_nang', $id_chuc_nang)->first();
        if (!$checkQuyen) {
            return response()->json([
                'message'  =>   'Bạn chưa được cấp quyền này',
                'status'   =>   false,
            ]);
        }
        $ten_chuc_vu = ChucVu::where('id', $id)->first();

        if ($ten_chuc_vu) {
            $ten_chuc_vu->delete();

            return response()->json([
                'status' => true,
                'message' => "Đã xóa chức vụ thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có Lỗi"
            ]);
        }
    }
    public function UpateChucVu(Request $request)
    {
        $id_chuc_nang = 1;
        $user = $this->isUserAdmin();
        $checkQuyen = ChiTietCapQuyen::where('id_chuc_vu', $user->id_chuc_vu)->where('id_chuc_nang', $id_chuc_nang)->first();
        if (!$checkQuyen) {
            return response()->json([
                'message'  =>   'Bạn chưa được cấp quyền này',
                'status'   =>   false,
            ]);
        }
        $ten_chuc_vu = ChucVu::where('id', $request->id)->first();
        if ($ten_chuc_vu) {
            $ten_chuc_vu->update([
                'ten_chuc_vu'             => $request->ten_chuc_vu,

            ]);

            return response()->json([
                'status' => true,
                'message' => "Cập Nhật tên quyền thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có Lỗi"
            ]);
        }
    }
}
