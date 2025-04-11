<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class ToChucCapChungChi extends Authenticatable
{
    use HasApiTokens;
    protected $table = "admims";
    protected $fillable = [
        'email',
        'password',
        'ten_to_chuc',
        'hotline',
        'dia_chi',
        'ho_ten_nguoi_dai_dien',
        'so_cccd',
        'sdt_nguoi_dai_dien',
        'email_nguoi_dai_dien',
        'is_duyet',
    ];
}
