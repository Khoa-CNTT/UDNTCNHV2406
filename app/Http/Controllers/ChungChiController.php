<?php

namespace App\Http\Controllers;

use App\Models\ChungChi;
use App\Models\ThongTinUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChungChiController extends Controller
{
    public function getData()
    {
        $check = Auth::guard('sanctum')->user();
        $data = ChungChi::where('id_hoc_vien', $check->id)
            ->whereNull('token')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function taoChungChi(Request $request)
    {
        $check = Auth::guard('sanctum')->user();
        $chung_chi = ThongTinUpload::where('thong_tin_uploads.id', $request->id)
           ->join('to_chuc_cap_chung_chis', 'thong_tin_uploads.id_to_chuc','to_chuc_cap_chung_chis.id')
           ->join('yeu_cau_caps', 'to_chuc_cap_chung_chis.id', 'yeu_cau_caps.id_to_chuc')
           ->whereColumn('thong_tin_uploads.email', 'yeu_cau_caps.email')
           ->join('hoc_viens', 'yeu_cau_caps.id_hoc_vien', 'hoc_viens.id')
            ->select('thong_tin_uploads.*','hoc_viens.id as id_hoc_vien')
            ->first();

        if ($chung_chi) {
            ChungChi::create([
                'so_hieu_chung_chi' => $chung_chi->so_hieu_chung_chi,
                'id_hoc_vien' =>$chung_chi->id_hoc_vien,
                'id_to_chuc' => $chung_chi->id_to_chuc,
                'so_tien' => 2000,
                'hinh_anh' => $chung_chi->hinh_anh,
                'khoa_hoc' => $chung_chi->khoa_hoc,
                'trinh_do' => $chung_chi->trinh_do,
                'ngay_cap' => $chung_chi->ngay_cap,
                'ket_qua' => $chung_chi->ket_qua,
                'id_thong_tin_upload' => $chung_chi->id,
                'tinh_trang' => 0,
            ]);
            return response()->json([
                'message'  =>   'Tạo Thành Công',
                'status'   =>   true,
            ]);
        } else {
            return response()->json([
                'message'  =>   'Có Lỗi Xảy Ra',
                'status'   =>   false,
            ]);
        }
    }
}
