<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichSuGiaoDich extends Model
{
    protected $table = 'lich_su_giao_dich';
    protected $fillable = [
        'id_vi',
        'MetaData_URL',
        'thoi_gian',
        'so_tien',
        'noi_dung',
    ];
}
