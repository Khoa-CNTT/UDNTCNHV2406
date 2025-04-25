<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ChiTietDonHang;

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
    public function chiTiet()
    {
        return $this->hasMany(ChiTietDonHang::class, 'id_don_hang');
    }

    // Gắn observer để xóa quan hệ
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($donHang) {
            // xóa luôn các detail
            $donHang->chiTiet()->delete();
        });
    }
}
