<?php

namespace App\Http\Controllers;

use App\Models\ChungChi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        Auth::guard('sanctum')->user();
        $chung_chi =  ChungChi::join('thong_tin_uploads', 'chung_chis.id_thong_tin_upload', 'thong_tin_uploads.id')
            ->join('hoc_viens', 'chung_chis.id_hoc_vien', 'hoc_viens.id')
            ->where('thong_tin_uploads.id', $request->id)
            ->where('hoc_viens.email', 'thong_tin_uploads.email')
            ->select('thong_tin_uploads.*', 'hoc_viens.id as hoc_vien_id')
            ->first();
        if ($chung_chi) {
            ChungChi::create([
                'so_hieu_chung_chi' => $chung_chi->so_hieu_chung_chi,
                'id_hoc_vien' => $chung_chi->hoc_vien_id,
                'id_to_chuc' => $chung_chi->id_to_chuc,
                'so_tien' => 2000,
                'hinh_anh' => $chung_chi->hinh_anh,
                'khoa_hoc' => $chung_chi->khoa_hoc,
                'trinh_do' => $chung_chi->trinh_do,
                'ngay_cap' => $chung_chi->ngay_cap,
                'ket_qua' => $chung_chi->ket_qua,
                'id_thong_tin_upload' => $chung_chi->id,
                'id_tinh_trang' => 0,
            ]);
        }
    }
}
