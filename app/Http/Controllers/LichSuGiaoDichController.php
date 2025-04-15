<?php

namespace App\Http\Controllers;

use App\Models\LichSuGiaoDich;
use Illuminate\Http\Request;

class LichSuGiaoDichController extends Controller
{
    public function adminGetLSGiaoDich()
    {
        $data = LichSuGiaoDich::join('chung_chis', 'lich_su_giao_dichs.id_chung_chi', 'chung_chis.id')
            ->join('hoc_viens', 'chung_chis.id_hoc_vien', 'hoc_viens.id')
            ->select('lich_su_giao_dichs.*', 'ho_ten')
            ->get();
        return response()->json([
            'data' => $data
        ]);
    }
}
