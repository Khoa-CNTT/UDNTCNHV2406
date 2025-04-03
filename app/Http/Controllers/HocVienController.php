<?php

namespace App\Http\Controllers;

use App\Models\HocVien;
use Illuminate\Http\Request;

class HocVienController extends Controller
{
    public function dangKy(Request $request)
    {
        HocVien::create([
            'email' =>$request->email,
            'password' => bcrypt($request->password),
            'ho_ten' =>$request->ho_ten,
            'ngay_sinh' =>$request->ngay_sinh,
            'gioi_tinh' =>$request->gioi_tinh,
            'so_cccd' =>$request->so_cccd,
            'sdt' =>$request->sdt,
            'dia_chi' =>$request->dia_chi,
            'is_duyet' => 0,
        ]);
        return response()->json([
            'message'  =>   'Vui lòng đợi duyệt tài khoản, mời bạn đang nhập lại sau.',
            'status'   =>   true
        ]);
    }
}
