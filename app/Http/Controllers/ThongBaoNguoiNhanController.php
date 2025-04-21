<?php

namespace App\Http\Controllers;

use App\Models\ThongBaoNguoiNhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThongBaoNguoiNhanController extends Controller
{
    public function xemThongBao()
    {
        $check = Auth::guard('sanctum')->user();
        $hoc_vien = $this->isUserHocVien();
        $to_chuc = $this->isUserToChucCapChungChi();

        if ($hoc_vien) {
            $data = ThongBaoNguoiNhan::join('thong_baos', 'thong_bao_nguoi_nhans.id_thong_bao', 'thong_baos.id')
                ->where('thong_bao_nguoi_nhans.id_hoc_vien', $check->id)
                ->select('thong_baos.tieu_de', 'thong_baos.noi_dung', 'thong_baos.created_at')
                ->get();
            return response()->json([
                'data' => $data,
            ]);
            // ->map(function ($item) { định dạng thời gian
            //     $item->created_at = Carbon::parse($item->created_at)->format('d/m/Y H:i');
            //     return $item;
            // });
        } else if ($to_chuc) {
            $data = ThongBaoNguoiNhan::join('thong_baos', 'thong_bao_nguoi_nhans.id_thong_bao', 'thong_baos.id')
                ->where('thong_bao_nguoi_nhans.id_to_chuc', $check->id)
                ->select('thong_baos.tieu_de', 'thong_baos.noi_dung', 'thong_baos.created_at')
                ->get();
            return response()->json([
                'data' => $data,
            ]);
        }
    }
    public function xoaThongBao($id){
        $data   =   ThongBaoNguoiNhan::where('id', $id)->first();
        if($data) {
            $data->delete();
            return response()->json([
                'status'    =>   true,
                'message'   =>   'Đã Xóa Thành Công'
            ]);
        } else {
            return response()->json([
                'status'    =>   false,
                'message'   =>   'Có Lỗi Xảy Ra'
            ]);
        }
    }
}
