<?php

namespace App\Http\Controllers;

use App\Models\ChiTietCapQuyen;
use App\Models\ChungChi;
use App\Models\DonHang;
use App\Models\ThongKe;
use Illuminate\Http\Request;

class ThongKeController extends Controller
{
    public function getThongKeDoanhThu()
    {

        $id_chuc_nang = 5;
        $user = $this->isUserAdmin();
        $checkQuyen = ChiTietCapQuyen::where('id_chuc_vu', $user->id_chuc_vu)->where('id_chuc_nang', $id_chuc_nang)->first();
        if (!$checkQuyen) {
            return response()->json([
                'message'  =>   'Bạn chưa được cấp quyền này',
                'status'   =>   false,
            ]);
        }

        $data = DonHang::where('is_thanh_toan',1)
        ->get();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function getThongKeNFTDaCap()
    {
        $id_chuc_nang = 5;
        $user = $this->isUserAdmin();
        $checkQuyen = ChiTietCapQuyen::where('id_chuc_vu', $user->id_chuc_vu)->where('id_chuc_nang', $id_chuc_nang)->first();
        if (!$checkQuyen) {
            return response()->json([
                'message'  =>   'Bạn chưa được cấp quyền này',
                'status'   =>   false,
            ]);
        }
        
        $data = ChungChi::where('tinh_trang',2)
        ->get();
        return response()->json([
            'data' => $data,
        ]);
    }
}
