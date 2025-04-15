<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HocVien extends Model
{
    protected $table = "hoc_viens";
    protected $fillable = [
        'email',
        'password',
        'ho_ten',
        'ngay_sinh',
        'gioi_tinh',
        'so_cccd',
        'sdt',
        'dia_chi',
        'hinh_anh',
        'is_duyet',
    ];
}
