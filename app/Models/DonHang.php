<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonHang extends Model
{
    use HasFactory;
    protected $table = 'don_hangs';
    protected $fillable = [
        'ma_don_hang',
        'tong_tien_thanh_toan',
        'is_thanh_toan',
        'ho_ten',
        'email',
        'id_hoc_vien'
    ];
}
