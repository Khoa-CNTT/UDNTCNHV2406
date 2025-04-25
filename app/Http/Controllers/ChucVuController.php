<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    public function getDataChucVu()
    {
        $data = ChucVu::select()->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function createDataChucVu(Request $request)
    {
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
        $ten_chuc_vu = ChucVu::where('id', $id)->first();

        if($ten_chuc_vu) {
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
        $ten_chuc_vu = ChucVu::where('id', $request->id)->first();
        if($ten_chuc_vu) {
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
