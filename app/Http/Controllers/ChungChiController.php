<?php

namespace App\Http\Controllers;

use App\Models\ChungChi;
use App\Models\HocVien;
use App\Models\ThongTinUpload;
use App\Services\PinataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\select;

class ChungChiController extends Controller
{
    protected $pinataService;

    public function __construct(PinataService $pinataService)
    {
        $this->pinataService = $pinataService;
    }

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
    public function getDataNft()
    {
        $check = $this->isUserHocVien();
        $data = ChungChi::join('hoc_viens', 'chung_chis.id_hoc_vien','hoc_viens.id')
                        ->join('to_chuc_cap_chung_chis', 'chung_chis.id_to_chuc','to_chuc_cap_chung_chis.id')
                        ->where('chung_chis.id_hoc_vien', $check->id)
                        ->where('chung_chis.tinh_trang', ChungChi::TINH_TRANG_DA_CAP_NFT)
                        ->select('chung_chis.*', 'hoc_viens.ho_ten','hoc_viens.email','hoc_viens.so_cccd' ,'hoc_viens.ngay_sinh', 'to_chuc_cap_chung_chis.ten_to_chuc')
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
        $data = ChungChi::join('hoc_viens', 'chung_chis.id_hoc_vien','hoc_viens.id')
        ->join('to_chuc_cap_chung_chis', 'chung_chis.id_to_chuc','to_chuc_cap_chung_chis.id')
        ->where('chung_chis.id_hoc_vien', $check->id)
            ->whereNull('chung_chis.token')
            ->select('chung_chis.*', 'hoc_viens.ho_ten','hoc_viens.email','hoc_viens.so_cccd' ,'hoc_viens.ngay_sinh', 'to_chuc_cap_chung_chis.ten_to_chuc')
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
    public function getDataADChungChi()
    {
        $check = $this->isUserAdmin();
        $data = ChungChi::join('hoc_viens', 'chung_chis.id_hoc_vien','hoc_viens.id')
        ->join('to_chuc_cap_chung_chis', 'chung_chis.id_to_chuc','to_chuc_cap_chung_chis.id')
            ->select('chung_chis.*', 'hoc_viens.ho_ten','hoc_viens.email','hoc_viens.so_cccd' ,'hoc_viens.ngay_sinh', 'to_chuc_cap_chung_chis.ten_to_chuc')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function getDataCapNft()
    {
        $check = $this->isUserAdmin();
        $data  = ChungChi::join('hoc_viens', 'chung_chis.id_hoc_vien','hoc_viens.id')
                         ->join('to_chuc_cap_chung_chis', 'chung_chis.id_to_chuc','to_chuc_cap_chung_chis.id')
                         ->where('chung_chis.tinh_trang', ChungChi::TINH_TRANG_DA_THANH_TOAN)
                         ->select(
                            'chung_chis.*',
                            'hoc_viens.ho_ten',
                            'hoc_viens.email',
                            'hoc_viens.so_cccd' ,
                            'hoc_viens.ngay_sinh',
                            'to_chuc_cap_chung_chis.ten_to_chuc',
                         )
                         ->get();

        return response()->json([
            'data' => $data,
        ]);

    }

    public function mintNFTtoApi($address, $metadataUri, $metadata)
    {
        $client = new \GuzzleHttp\Client();
        $res    = $client->post("http://localhost:3000/api/mint-nft", [
            'json' => [
                'recipient' => $address,
                'tokenURI'  => $metadataUri,
                'attributes' => $metadata
            ]
        ]);

        $data = json_decode($res->getBody(), true);
        return $data;
    }

    public function createCapNft(Request $request)
    {
        $this->isUserAdmin();
        $sinh_vien = HocVien::where('hoc_viens.id', $request->id_hoc_vien)
                            ->join('vi_nfts', 'hoc_viens.id', 'vi_nfts.id_hoc_vien')
                            ->select(
                                'vi_nfts.*',
                            )
                            ->first();

        $metadata = [
            "created_at"        => $request->created_at,
            "email"             => $request->email,
            "hinh_anh"          => $request->hinh_anh,
            "ho_ten"            => $request->ho_ten,
            "ket_qua"           => $request->ket_qua,
            "khoa_hoc"          => $request->khoa_hoc,
            "ngay_cap"          => $request->ngay_cap,
            "ngay_sinh"         => $request->ngay_sinh,
            "so_cccd"           => $request->so_cccd,
            "so_hieu_chung_chi" => $request->so_hieu_chung_chi,
            "ten_to_chuc"       => $request->ten_to_chuc,
            "trinh_do"          => $request->trinh_do,
        ];

        $metadataUri = $this->pinataService->uploadMetadata($metadata);

        $txHash = $this->mintNFTtoApi($sinh_vien->dia_chi_vi, $metadataUri, $metadata);

        $chung_chi = ChungChi::where('id', $request->id)->first();
        if ($chung_chi) {
            $chung_chi->token = $txHash['transactionHash'];
            $chung_chi->MetaData_URL = $metadataUri;
            $chung_chi->tinh_trang = ChungChi::TINH_TRANG_DA_CAP_NFT;
            $chung_chi->save();
        }

        return response()->json([
            'success' => true,
            'mesasage' => 'Mint NFT thành công',
        ]);
    }
}
