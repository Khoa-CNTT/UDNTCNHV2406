<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YeuCauCap extends Model
{
    protected $table = 'yeu_cau_caps';

    protected $fillable = [
        'id_to_chuc',
        'id_hoc_vien',
        'tinh_trang',
        'id_chung_chi',
    ];
}
