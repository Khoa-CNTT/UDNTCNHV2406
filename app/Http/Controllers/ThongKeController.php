<?php

namespace App\Http\Controllers;

use App\Models\ThongKe;
use Illuminate\Http\Request;

class ThongKeController extends Controller
{
    public function getData()
    {
        $dulieu = ThongKe::get();
        return response()->json([
            'data' => $dulieu
        ]);
    }
}
