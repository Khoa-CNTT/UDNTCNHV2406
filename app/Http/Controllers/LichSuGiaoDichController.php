<?php

namespace App\Http\Controllers;

use App\Models\LichSuGiaoDich;
use Illuminate\Http\Request;

class LichSuGiaoDichController extends Controller
{
    public function getData()
    {
        $dulieu = LichSuGiaoDich::get();
        return response()->json([
            'data' => $dulieu
        ]);
    }
}
