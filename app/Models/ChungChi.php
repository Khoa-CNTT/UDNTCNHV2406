<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ChungChi extends Model
{
    use HasFactory;
    protected $table = 'chung_chis';
    protected $fillable = [
        'so_hieu_chung_chi',
        'id_hoc_vien',
        'id_to_chuc',
        'so_tien',
        'hinh_anh',
        'token',
        'MetaData_URL',
        'khoa_hoc',
        'trinh_do',
        'ngay_cap',
        'ket_qua',
        'id_thong_tin_upload',
        'ghi_chu',
        'tinh_trang',
    ];
}
