<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;
use App\Models\ChungChi;
use App\Models\HocVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChiTietDonHangController extends Controller
{
    public function themVaoThanhToan(Request $request)
    {
        $hoc_vien = Auth::guard('sanctum')->user();

        if (!$hoc_vien) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa đăng nhập.'
            ]);
        }

        $chung_chi = ChungChi::where('id', $request->id_chung_chi)
            ->whereNull('token')
            ->where('id_hoc_vien', $hoc_vien->id)
            ->first();

        if (!$chung_chi) {
            return response()->json([
                'status' => false,
                'message' => 'Chứng chỉ không tồn tại hoặc đã có token.'
            ]);
        }

        $da_co = ChiTietDonHang::where('id_chung_chi', $chung_chi->id)->first();
        if ($da_co) {
            return response()->json([
                'status' => false,
                'message' => 'Chứng chỉ này đã có trong giỏ hàng.'
            ]);
        }

        ChiTietDonHang::create([
            'id_chung_chi'  => $chung_chi->id,
            'id_hoc_vien'   => $hoc_vien->id,
            'id_don_hang'   => 0,
            'so_tien'       => $chung_chi->so_tien,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm vào thanh toán thành công.'
        ]);
    }
    public function getData()
    {
        $check = Auth::guard('sanctum')->user();
        $data = ChiTietDonHang::join('chung_chis', 'chung_chis.id', 'chi_tiet_don_hangs.id_chung_chi')
            ->where('chi_tiet_don_hangs.id_hoc_vien', $check->id)
            ->whereNull('chung_chis.token')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }
}
