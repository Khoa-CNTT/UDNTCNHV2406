<?php

namespace App\Http\Controllers;

use App\Mail\HocVienThanhToan;
use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DonHangController extends Controller
{
    //trước khi bấm thanh toán thì phải thêm vào giỏ hàng/ chi tiết đơn hàng
    public function actionThanhToan(Request $request)
    {
        try {
            $hoc_vien = Auth::guard('sanctum')->user();
            if ($hoc_vien) {
                if (count($request->ds_chung_chi_thanh_toan) < 1) {
                    return response()->json([
                        'status' => false,
                        'message' => "Không Có Chứng Chỉ Nào Thanh Toán."
                    ]);
                } else {
                    $don_hang = DonHang::create([
                        'ma_don_hang' => '',
                        'tong_tien_thanh_toan' => 0,
                        'is_thanh_toan' => 0,
                        'ho_ten' => $hoc_vien->ho_ten,
                        'email' => $hoc_vien->email,
                        'id_hoc_vien' => $hoc_vien->id,
                    ]);

                    $ma_don_hang = "HDBD" . (100100 + $don_hang->id);
                    $tong_tien_thanh_toan = 0;
                    foreach ($request->ds_chung_chi_thanh_toan as $key => $value) {
                        $tong_tien_thanh_toan += $value['so_tien'];
                        ChiTietDonHang::where('id', $value['id'])->update([
                            'id_don_hang' => $don_hang->id,
                        ]);
                    };

                    $don_hang->ma_don_hang = $ma_don_hang;
                    $don_hang->tong_tien_thanh_toan = $tong_tien_thanh_toan;
                    $don_hang->save();

                    $link   =   "https://img.vietqr.io/image/MB-0347341227-qr_only.png?amount=" . $tong_tien_thanh_toan . "&addInfo=" . $ma_don_hang;

                    // $bien_1['ten_nguoi_nhan']           =   $dia_chi->ten_nguoi_nhan;
                    // $bien_1['so_dien_thoai_nhan']       =   $dia_chi->so_dien_thoai;
                    // $bien_1['dia_chi_nhan_hang']        =   $dia_chi->dia_chi;
                    $bien_1['tong_tien_thanh_toan']     =   $tong_tien_thanh_toan;
                    $bien_1['link_qr_code']             =   $link;
                    $bien_2                             =   $request->ds_chung_chi_thanh_toan;

                    Mail::to($hoc_vien->email)->send(new HocVienThanhToan($bien_1, $bien_2));
                    return response()->json([
                        'status' => true,
                        'message' => "Kiểm Tra Email Để Thanh Toán"
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Có Lỗi Xảy Ra"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Có Lỗi Xảy Ra"
            ]);
        }
    }
}
