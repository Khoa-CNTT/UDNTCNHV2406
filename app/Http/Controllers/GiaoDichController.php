<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\GiaoDich;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GiaoDichController extends Controller
{
    public function index()
    {
        $client = new Client();
        $payload = [
            'USERNAME' => env('MB_USERNAME'),
            'PASSWORD' => env('MB_PASSWORD'),
            'NUMBER_MB' => env('MB_NUMBER'),
            "DAY_BEGIN"     => Carbon::today()->format('d/m/Y'),
            "DAY_END"       => Carbon::today()->format('d/m/Y'),
        ];

        try {
            $response = $client->post('https://api-mb.dzmid.io.vn/api/transactions', [
                'json' => $payload
            ]);

            $data   = json_decode($response->getBody(), true);
            $duLieu = $data['data'];
            foreach ($duLieu as $key => $value) {
                $giaoDich   = GiaoDich::where('pos', $value['pos'])
                    ->where('creditAmount', $value['creditAmount'])
                    ->where('description', $value['description'])
                    ->first();

                if (!$giaoDich) {
                    GiaoDich::create([
                        'creditAmount'      =>  $value['creditAmount'],
                        'description'       =>  $value['description'],
                        'pos'               =>  $value['pos'],
                    ]);
                    // Khi mà chúng ta tạo giao dịch => tìm giao dịch dựa vào description => đổi trạng thái của đơn hàng
                    $description = $value['description'];
                    // Tìm vị trí của chuỗi "HDBH"
                    // $startIndex = strpos($description, "HDBH");
                    // if ($startIndex !== false) {
                    //     $maDonHang = substr($description, $startIndex, strcspn(substr($description, $startIndex), " \t\n\r\0\x0B"));
                    // }
                    if (preg_match('/HDBH(\d+)/', $description, $matches)) {
                        $maDonHang  = $matches[0];
                        $donHang    = DonHang::where('ma_don_hang', $maDonHang)
                            ->where('tong_tien_thanh_toan', '<=', $value['creditAmount'])
                            ->first();
                        if ($donHang) {
                            $donHang->is_thanh_toan = 1;
                            $donHang->save();
                        }
                    }
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
}
