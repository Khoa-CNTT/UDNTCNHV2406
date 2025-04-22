<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BaoCaoController;
use App\Http\Controllers\ChiTietDonHangController;
use App\Http\Controllers\ChungChiController;
use App\Http\Controllers\CoQuanXacThucController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\HocVienController;
use App\Http\Controllers\LichSuGiaoDichController;
use App\Http\Controllers\ThongBaoController;
use App\Http\Controllers\ThongBaoNguoiNhanController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\ThongTinUploadController;
use App\Http\Controllers\ToChucCapChungChiController;
use App\Http\Controllers\UpFileImageController;
use App\Http\Controllers\YeuCauCapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/admin/data', [AdminController::class,'getData']);
Route::post('/admin/dang-ky',[AdminController::class,'dangKy']);
Route::post('/admin/dang-nhap', [AdminController::class,'dangNhap']);
Route::post('/admin/kiem-tra-chia-khoa', [AdminController::class,'kiemTraChiaKhoa']);
Route::get('/admin/dang-xuat', [AdminController::class,'dangXuat']);
Route::get('/admin/dang-xuat-all', [AdminController::class,'dangXuatAll']);
Route::get('/admin/profile', [AdminController::class,'Profile']);
Route::post('/admin/update-profile', [AdminController::class,'updateProfile']);
Route::post('/admin/update-mat-khau', [AdminController::class,'updateMatKhau']);
Route::post('/admin/quen-mat-khau', [AdminController::class, 'actionQuenmatKhau']);
Route::post('/admin/lay-lai-mat-khau/{hash_reset}', [AdminController::class, 'actionLayLaiMatKhau']);

Route::post('admin/admin/doi-trang-thai', [AdminController::class,'doiTrangThai']);




Route::post('/hoc-vien/dang-ky', [HocVienController::class,'dangKy']);
Route::post('/hoc-vien/dang-nhap', [HocVienController::class,'dangNhap']);
Route::get('/hoc-vien/data', [HocVienController::class,'getData']);
Route::post('/hoc-vien/kiem-tra-chia-khoa', [HocVienController::class,'kiemTraChiaKhoa']);
Route::get('/hoc-vien/dang-xuat', [HocVienController::class,'dangXuat']);
Route::get('/hoc-vien/dang-xuat-all', [HocVienController::class,'dangXuatAll']);
Route::get('/hoc-vien/profile', [HocVienController::class,'Profile']);
Route::post('/hoc-vien/update-profile', [HocVienController::class,'updateProfile']);
Route::post('/hoc-vien/update-mat-khau', [HocVienController::class,'updateMatKhau']);
Route::post('/hoc-vien/quen-mat-khau', [HocVienController::class, 'actionQuenmatKhau']);
Route::post('/hoc-vien/lay-lai-mat-khau/{hash_reset}', [HocVienController::class, 'actionLayLaiMatKhau']);

Route::post('admin/hoc-vien/doi-trang-thai', [HocVienController::class,'doiTrangThai']);




Route::post('/to-chuc/dang-ky', [ToChucCapChungChiController::class,'dangKy']);
Route::post('/to-chuc/dang-nhap', [ToChucCapChungChiController::class,'dangNhap']);
Route::get('/to-chuc/data', [ToChucCapChungChiController::class,'getData']);
Route::post('/to-chuc/kiem-tra-chia-khoa', [ToChucCapChungChiController::class,'kiemTraChiaKhoa']);
Route::get('/to-chuc/dang-xuat-all', [ToChucCapChungChiController::class,'dangXuatAll']);
Route::get('/to-chuc/dang-xuat', [ToChucCapChungChiController::class,'dangXuat']);
Route::get('/to-chuc/profile', [ToChucCapChungChiController::class,'Profile']);
Route::post('/to-chuc/update-profile', [ToChucCapChungChiController::class,'updateProfile']);
Route::post('/to-chuc/update-mat-khau', [ToChucCapChungChiController::class,'updateMatKhau']);
Route::post('/to-chuc/quen-mat-khau', [ToChucCapChungChiController::class, 'actionQuenmatKhau']);
Route::post('/to-chuc/lay-lai-mat-khau/{hash_reset}', [ToChucCapChungChiController::class, 'actionLayLaiMatKhau']);

Route::post('admin/to-chuc/doi-trang-thai', [ToChucCapChungChiController::class,'doiTrangThai']);




Route::get('/admin/lich-su-giao-dich', [LichSuGiaoDichController::class,'adminGetLSGiaoDich']);



Route::post('/admin/gui-thong-bao', [ThongBaoController::class,'guiThongBao']);
Route::get('/admin/data-thong-bao', [ThongBaoController::class,'getData']);



Route::get('/xem-thong-bao', [ThongBaoNguoiNhanController::class,'xemThongBao']);
Route::delete('/xoa-thong-bao/{id}', [ThongBaoNguoiNhanController::class,'xoaThongBao']);



Route::post('/hoc-vien/thanh-toan', [DonHangController::class,'actionThanhToan']);//bước 2


Route::post('/them-vao-thanh-toan', [ChiTietDonHangController::class,'themVaoThanhToan']); //bước1
Route::get('/hoc_vien/can-thanh-toan', [ChiTietDonHangController::class,'getData']);


Route::get('/hoc_vien/chung-chi-chua-cap', [ChungChiController::class,'getData']);
Route::post('/to-chuc/tao-chung-chi', [ChungChiController::class,'taoChungChi']);//chưa có token


Route::post('/hoc-vien/yeu-cau-cap', [YeuCauCapController::class, 'guiYeuCauCap']);
Route::get('/get-data', [YeuCauCapController::class, 'getData']);

Route::get('/to-chuc/truy-xuat-getdata/{id}', [YeuCauCapController::class, 'getDataTruyXuat']);


Route::get('/get-data', [YeuCauCapController::class, 'getData']);


Route::post('/upload-folder', [UpFileImageController::class, 'uploadFolder']);


Route::post('/import-excel', [ThongTinUploadController::class, 'import']);
Route::get('/get-data', [ThongTinUploadController::class, 'getData']);



//php artisan storage:link
//composer require shuchkin/simplexlsx


// Route::post('/co-quan/dang-ky', [CoQuanXacThucController::class,'dangKy']);
// Route::post('/co-quan/dang-nhap', [CoQuanXacThucController::class,'dangNhap']);
// Route::get('/co-quan/data', [CoQuanXacThucController::class,'getData']);
// Route::post('/co-quan/kiem-tra-chia-khoa', [CoQuanXacThucController::class,'kiemTraChiaKhoa']);
// Route::get('/co-quan/dang-xuat', [CoQuanXacThucController::class,'dangXuatAll']);
// Route::get('/co-quan/profile', [CoQuanXacThucController::class,'Profile']);
// Route::post('/co-quan/update-profile', [CoQuanXacThucController::class,'updateProfile']);
// Route::post('/co-quan/update-mat-khau', [CoQuanXacThucController::class,'updateMatKhau']);
