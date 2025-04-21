<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ThongBaoNguoiNhan extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'thong_bao_nguoi_nhans';
    protected $fillable = [
        'id_thong_bao',
        'id_hoc_vien',
        'id_to_chuc',
        'xem',
    ];
}
