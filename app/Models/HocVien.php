<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HocVien extends Model
{
    protected $table = "admims";
    protected $fillable = [
        'email',
        'password',
        'ho_ten',
        'slug_ten',
        'ngay_sinh',
        'gioi_tinh',
        'so_cccd',
        'sdt',
        'dia_chi',
        'is_duyet',
    ];
}
