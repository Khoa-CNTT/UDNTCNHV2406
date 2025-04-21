<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CoQuanXacThuc extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
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
        'hinh_anh',
        'hash_reset',
        'is_duyet'
    ];
}
