<?php

namespace App\Http\Controllers;

use App\Models\ChungChi;
use Illuminate\Http\Request;

class ChungChiController extends Controller
{
    public function getData()
    {
        $dulieu = ChungChi::get();
        return response()->json([
            'data' => $dulieu
        ]);
    }
}
