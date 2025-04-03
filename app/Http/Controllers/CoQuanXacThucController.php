<?php

namespace App\Http\Controllers;

use App\Models\CoQuanXacThuc;
use Illuminate\Http\Request;

class CoQuanXacThucController extends Controller
{
    public function dangKy(Request $request)
    {
        CoQuanXacThuc::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'ten_co_quan' => $request->ten_co_quan,
            'hotline' => $request->hotline,
            'dia_chi' => $request->dia_chi,
            'ho_ten_nguoi_dai_dien' => $request->ho_ten_nguoi_dai_dien,
            'so_cccd' => $request->so_cccd,
            'sdt_nguoi_dai_dien' => $request->sdt_nguoi_dai_dien,
            'email_nguoi_dai_dien' => $request->email_nguoi_dai_dien,
            'is_duyet' => 0,
        ]);
        return response()->json([
            'message'  =>   'Vui lòng đợi duyệt tài khoản, mời bạn đang nhập lại sau.',
            'status'   =>   true
        ]);
    }
}
