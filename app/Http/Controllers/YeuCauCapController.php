<?php

namespace App\Http\Controllers;

use App\Models\HocVien;
use App\Models\YeuCauCap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YeuCauCapController extends Controller
{
    //api
    public function guiYeuCauCap(Request $request)
    {
        $check = Auth::guard('sanctum')->user();
        $hoc_vien = $this->isUserHocVien();
        if ($hoc_vien) {
            $yeuCauCap = YeuCauCap::create([
                'id_to_chuc' => $request->id_to_chuc,
                'id_hoc_vien' => $check->id,
                'ho_ten' => $check->ho_ten,
                'so_cccd' => $check->so_cccd,
                'email' => $check->email,
                'so_hieu_chung_chi' => $request->so_hieu_chung_chi,
                'trang_thai' => 0,
            ]);
            return response()->json([
                'status'    =>   true,
                'message'   =>   'Đã Yêu Cầu Thành Công',
            ]);
        } else {
            return response()->json([
                'status'    =>   false,
                'message'   =>   'Có Lỗi Xảy Ra'
            ]);
        }
    }
    public function getData()
    {
        $check = Auth::guard('sanctum')->user();
        $hoc_vien = $this->isUserHocVien();
        $to_chuc = $this->isUserToChucCapChungChi();
        if ($check) {
            if ($hoc_vien) {
                $data = YeuCauCap::where('id_hoc_vien', $check->id)
                    ->join('to_chuc_cap_chung_chis', 'to_chuc_cap_chung_chis.id', 'yeu_cau_caps.id_to_chuc')
                    ->select('to_chuc_cap_chung_chis.ten_to_chuc', 'yeu_cau_caps.*')
                    ->get();
            } else if ($to_chuc) {
                $data = YeuCauCap::where('id_to_chuc', $check->id)
                    ->join('hoc_viens', 'hoc_viens.id', 'yeu_cau_caps.id_hoc_vien')
                    ->get();
            }
            return response()->json([
                'data' => $data
            ]);
        }
    }
}
