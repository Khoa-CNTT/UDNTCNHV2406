<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class CoQuanXacThuc extends Authenticatable
{
    use HasApiTokens;
    protected $table = 'co_quan_xac_thucs';
    protected $fillable = [
        'email',
        'password',
        'ten_co_quan',
        'hotline',
        'dia_chi',
        'ho_ten_nguoi_dai_dien',
        'so_cccd',
        'sdt_nguoi_dai_dien',
        'email_nguoi_dai_dien',
        'is_duyet'
    ];
}
