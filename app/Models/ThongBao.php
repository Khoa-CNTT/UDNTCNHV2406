<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    protected $table = 'thong_baos';
    protected $fillable = [
        'thoi_gian',
        'tieu_de',
        'noi_dung',
        'id_co_quan',
        'id_hoc_vien',
        'id_to_chuc'
    ];
}
