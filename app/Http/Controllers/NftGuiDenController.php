<?php

namespace App\Http\Controllers;

use App\Models\HocVien;
use App\Models\NftGuiDen;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class NftGuiDenController extends Controller
{
    public function nhanNFT()
    {
        $check = $this->isUserHocVien();
        if ($check) {
            $data = NftGuiDen::where('email_nguoi_nhan', $check->email)
                ->get();
            return response([
                'data' => $data,
            ]);
        }
    }
     public function xemChiTietNFTGuiDen()
    {
        $check = $this->isUserHocVien();
        if ($check) {
            $data = NftGuiDen::where('email_nguoi_nhan', $check->email)
                ->first();
            return response([
                'data' => $data,
            ]);
        }
    }
    public function guiNFT(Request $request)
    {
        $check = $this->isUserHocVien();

        if ($check) {
            if ($request->email_nguoi_nhan === $check->email) {
                return response()->json([
                    'status' => false,
                    'message' => "Không Được Gửi Cho Tự Gửi Cho Chính Mình",
                ]);
            }
            $hocVienNhan = HocVien::where('email', $request->email_nguoi_nhan)->first();

            if ($hocVienNhan) {
                $guiNFT = NftGuiDen::create([
                    'email_nguoi_nhan' => $request->email_nguoi_nhan,
                    'email_nguoi_gui' => $check->email,
                    'token' => $request->token,
                    'MetaData_URL' => $request->MetaData_URL,
                ]);
                return response()->json([
                    'status' => true,
                    'message' => "Chia Sẻ Thành Công",
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Email Người Nhận Không Có Trong Hệ Thống",
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có Lỗi Xảy Ra",
            ]);
        }
    }
    public function xoaNFTGuiDen(Request $request)
    {
        $hoc_vien = $this->isUserHocVien();

        try {
            if ($hoc_vien) {
                foreach ($request->ds_thong_bao_can_xoa as $id) {
                    NftGuiDen::where('id', $id)
                        ->where('email_nguoi_nhan', $hoc_vien->email)
                        ->delete();
                }
                return response()->json([
                    'status'    => true,
                    'message'   => 'Đã Xóa Thành Công'
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Có Lỗi Xảy Ra'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'message'   => 'Có Lỗi Xảy Ra'
            ]);
        }
    }
}
