<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToChucCapChungChi extends Model
{
    protected $table = "admims";
    protected $fillable = [
        'email',
        'password',
        'ten_to_chuc',
        'slug_ten',
        'hotline',
        'dia_chi',
        'ho_ten_nguoi_dai_dien',
        'so_cccd',
        'sdt_nguoi_dai_dien',
        'email_nguoi_dai_dien',
        'is_duyet',
    ];
}
