<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'nhan_viens';
    protected $fillable = [
        'email',
        'password',
        'ho_ten',
        'ngay_sinh',
        'gioi_tinh',
        'so_cccd',
        'sdt',
        'dia_chi',
        'id_chuc_vu',
        'is_duyet'
    ];
}
