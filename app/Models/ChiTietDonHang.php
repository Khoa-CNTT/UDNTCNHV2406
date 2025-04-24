<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DonHang;
use Illuminate\Support\Facades\Log;

class ChiTietDonHang extends Model
{
    use HasFactory;
    protected $table = 'chi_tiet_don_hangs';
    protected $fillable = [
        'id_chung_chi',
        'id_hoc_vien',
        'id_don_hang',
        'so_tien',
    ];
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'id_don_hang', 'id');
    }
    protected static function booted()
{
    static::deleting(function ($chiTietDonHang) {
        // Thực hiện logic trước khi xóa
        Log::info("ChiTietDonHang ID {$chiTietDonHang->id} đã bị xóa!");
    });
}
}
