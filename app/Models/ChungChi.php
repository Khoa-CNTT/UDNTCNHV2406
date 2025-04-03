<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChungChi extends Model
{
    protected $table = 'chung_chis';

    protected $fillable = [
        'so_hieu_chung_chi',
        'id_hoc_vien',
        'id_to_chuc',
        'so_tien',
        'url_thanh_toan',
        'file',
        'token',
        'id_tinh_trang',
        'khoa_hoc',
        'ngay_cap',
        'ket_qua'
    ];
    
}
