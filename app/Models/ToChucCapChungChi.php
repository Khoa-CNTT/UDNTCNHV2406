<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToChucCapChungChi extends Model
{
    protected $table = "to_chuc_cap_chung_chis";
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
        'hinh_anh',
        'is_duyet',
    ];
}
