<?php

namespace App\Http\Controllers;

use App\Models\ChungChi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChungChiController extends Controller
{
    public function getData()
    {
        $check = Auth::guard('sanctum')->user();
        $data = ChungChi::where('id_hoc_vien', $check->id)
            ->whereNull('token')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }
}
