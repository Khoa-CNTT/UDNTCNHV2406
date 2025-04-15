<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TinhTrangChungChi extends Model
{
    protected $table = 'tinh_trang_chung_chis';
    protected $fillable = [
        'tinh_trang',
        'mo_ta'
    ];
}
