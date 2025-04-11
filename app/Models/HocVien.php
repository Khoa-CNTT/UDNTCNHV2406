<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class HocVien extends Authenticatable
{
    use HasApiTokens;
    protected $table = "admims";
    protected $fillable = [
        'email',
        'password',
        'ho_ten',
        'ngay_sinh',
        'gioi_tinh',
        'so_cccd',
        'sdt',
        'dia_chi',
        'is_duyet',
    ];
}
