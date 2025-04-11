<?php

namespace App\Http\Controllers;

use App\Models\BaoCao;
use Illuminate\Http\Request;

class BaoCaoController extends Controller
{
    public function getData()
    {
        $dulieu = BaoCao::get();
        return response()->json([
            'data' => $dulieu
        ]);
    }
}
