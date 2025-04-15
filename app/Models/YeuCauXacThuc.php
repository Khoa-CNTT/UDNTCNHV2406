<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YeuCauXacThuc extends Model
{
    protected $table = 'yeu_cau_xac_thucs';
    protected $fillable = [
        'id_hoc_vien',
        'id_co_quan',
        'tinh_trang',
        'id_chung_chi',
    ];
}
