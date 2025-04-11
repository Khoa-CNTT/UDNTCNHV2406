<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function isUserAdmin(){
        $user = Auth::guard('sanctum')->user();
        if($user instanceof \App\Models\Admin){
            return $user;
        }
        return false;
    }
    public function isUserHocVien(){
        $user = Auth::guard('sanctum')->user();
        if($user instanceof \App\Models\HocVien){
            return $user;
        }
        return false;
    }
    public function isUserCoQuanXacThuc(){
        $user = Auth::guard('sanctum')->user();
        if($user instanceof \App\Models\CoQuanXacThuc){
            return $user;
        }
        return false;
    }
    public function isUserToChucCapChungChi(){
        $user = Auth::guard('sanctum')->user();
        if($user instanceof \App\Models\ToChucCapChungChi){
            return $user;
        }
        return false;
    }
}
