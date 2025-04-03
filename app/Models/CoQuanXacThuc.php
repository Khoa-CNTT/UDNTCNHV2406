<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoQuanXacThuc extends Model
{
    protected $table = 'co_quan_xac_thucs';

    protected $fillable = [
        'email',
        'password',
        'ten_co_quan',
        'slug_ten',
        'hotline',
        'dia_chi',
        'ho_ten_nguoi_dai_dien',
        'so_cccd',
        'sdt_nguoi_dai_dien',
        'email_nguoi_dai_dien',
        'is_duyet'
    ];
}
