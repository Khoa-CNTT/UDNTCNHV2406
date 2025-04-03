<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dangKy(Request $request)
    {
        Admin::create([
            'email'                 =>  $request->email,
            'password'              =>  bcrypt($request->password),
        ]);
        return response()->json([
            'message'  =>   'Đăng ký tài khoản thành công.',
            'status'   =>   true
        ]);
    }
}
