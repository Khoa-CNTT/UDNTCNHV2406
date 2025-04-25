<?php

namespace App\Http\Controllers;

use App\Models\ChungChi;
use App\Models\ThongTinUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChungChiController extends Controller
{
    public function getDataTc()
    {
        $check = $this->isUserToChucCapChungChi();
        $data = ChungChi::join('hoc_viens', 'chung_chis.id_hoc_vien','hoc_viens.id')
        ->whereColumn('chung_chis.id_hoc_vien', 'hoc_viens.id')
        ->where('chung_chis.id_to_chuc', $check->id)
            ->whereNotNull('token')
            ->select('chung_chis.*', 'hoc_viens.ho_ten','hoc_viens.email','hoc_viens.so_cccd' ,'hoc_viens.ngay_sinh')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function changeVoHieuHoa(Request $request)
    {

        $chung_chi = ChungChi::where('id', $request->id)->first();

        if ($chung_chi) {
            if ($chung_chi->tinh_trang == 1) {
                $chung_chi->tinh_trang = 2;
                $chung_chi->ghi_chu = $request ->ghi_chu;
                $chung_chi->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đã Vô Hiêu Hóa Thành Công"
                ]);
            } else if ($chung_chi->tinh_trang == 2) {
                $chung_chi->tinh_trang = 1;
                $chung_chi->ghi_chu = null;
                $chung_chi->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đã Mở Vô Hiệu Hóa Thành Công"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có Lỗi Xảy Ra"
            ]);
        }
    }
    public function getDataHv()
    {
        $check = $this->isUserHocVien();
        $data = ChungChi::where('id_hoc_vien', $check->id)
            ->whereNull('token')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function taoChungChi(Request $request)
    {
        $check = $this->isUserToChucCapChungChi();
        if ($check) {
            $chung_chi = ThongTinUpload::where('thong_tin_uploads.id', $request->id)
                ->join('to_chuc_cap_chung_chis', 'thong_tin_uploads.id_to_chuc', 'to_chuc_cap_chung_chis.id')
                ->join('yeu_cau_caps', 'to_chuc_cap_chung_chis.id', 'yeu_cau_caps.id_to_chuc')
                ->whereColumn('thong_tin_uploads.email', 'yeu_cau_caps.email')
                ->join('hoc_viens', 'yeu_cau_caps.id_hoc_vien', 'hoc_viens.id')
                ->select('thong_tin_uploads.*', 'hoc_viens.id as id_hoc_vien')
                ->first();

            if ($chung_chi) {
                ChungChi::create([
                    'so_hieu_chung_chi' => $chung_chi->so_hieu_chung_chi,
                    'id_hoc_vien' => $chung_chi->id_hoc_vien,
                    'id_to_chuc' => $chung_chi->id_to_chuc,
                    'so_tien' => 2000,
                    'hinh_anh' => $chung_chi->hinh_anh,
                    'khoa_hoc' => $chung_chi->khoa_hoc,
                    'trinh_do' => $chung_chi->trinh_do,
                    'ngay_cap' => $chung_chi->ngay_cap,
                    'ket_qua' => $chung_chi->ket_qua,
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
        }else{
            return response()->json([
                'message'  =>   'Có Lỗi Xảy Ra',
                'status'   =>   false,
            ]);
        }
    }
}
