<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BaoCaoController;
use App\Http\Controllers\ChungChiController;
use App\Http\Controllers\CoQuanXacThucController;
use App\Http\Controllers\HocVienController;
use App\Http\Controllers\LichSuGiaoDichController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\ToChucCapChungChiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/admin/dang-ky',[AdminController::class,'dangKy']);
Route::post('/admin/dang-nhap', [AdminController::class,'dangNhap']);
Route::post('/admin/kiem-tra-chia-khoa', [AdminController::class,'kiemTraChiaKhoa']);
Route::get('/admin/dang-xuat', [AdminController::class,'dangXuatAll']);
Route::get('/admin/profile', [AdminController::class,'Profile']);
Route::post('/admin/update-profile', [AdminController::class,'updateProfile']);
Route::post('/admin/update-mat-khau', [AdminController::class,'updateMatKhau']);
// Route::post('/admin/quen-mat-khau', [AdminController::class, 'actionQuenmatKhau']);
// Route::post('/admin/lay-lai-mat-khau/{hash_reset}', [AdminController::class, 'actionLayLaiMatKhau']);


Route::post('/hoc-vien/dang-ky', [HocVienController::class,'dangKy']);
Route::post('/hoc-vien/dang-nhap', [HocVienController::class,'dangNhap']);
Route::get('/hoc-vien/data', [HocVienController::class,'getData']);
Route::post('/hoc-vien/kiem-tra-chia-khoa', [HocVienController::class,'kiemTraChiaKhoa']);
Route::get('/hoc-vien/dang-xuat', [HocVienController::class,'dangXuatAll']);
Route::get('/hoc-vien/profile', [HocVienController::class,'Profile']);
Route::post('/hoc-vien/update-profile', [HocVienController::class,'updateProfile']);
Route::post('/hoc-vien/update-mat-khau', [HocVienController::class,'updateMatKhau']);




Route::post('/to-chuc/dang-ky', [ToChucCapChungChiController::class,'dangKy']);
Route::post('/to-chuc/dang-nhap', [ToChucCapChungChiController::class,'dangNhap']);
Route::get('/to-chuc/data', [ToChucCapChungChiController::class,'getData']);
Route::post('/to-chuc/kiem-tra-chia-khoa', [ToChucCapChungChiController::class,'kiemTraChiaKhoa']);
Route::get('/to-chuc/dang-xuat', [ToChucCapChungChiController::class,'dangXuatAll']);
Route::get('/to-chuc/profile', [ToChucCapChungChiController::class,'Profile']);
Route::post('/to-chuc/update-profile', [ToChucCapChungChiController::class,'updateProfile']);
Route::post('/to-chuc/update-mat-khau', [ToChucCapChungChiController::class,'updateMatKhau']);


Route::post('/co-quan/dang-ky', [CoQuanXacThucController::class,'dangKy']);
Route::post('/co-quan/dang-nhap', [CoQuanXacThucController::class,'dangNhap']);
Route::get('/co-quan/data', [CoQuanXacThucController::class,'getData']);
Route::post('/co-quan/kiem-tra-chia-khoa', [CoQuanXacThucController::class,'kiemTraChiaKhoa']);
Route::get('/co-quan/dang-xuat', [CoQuanXacThucController::class,'dangXuatAll']);
Route::get('/co-quan/profile', [CoQuanXacThucController::class,'Profile']);
Route::post('/co-quan/update-profile', [CoQuanXacThucController::class,'updateProfile']);
Route::post('/co-quan/update-mat-khau', [CoQuanXacThucController::class,'updateMatKhau']);


Route::get('/admin/lich-su-giao-dich', [LichSuGiaoDichController::class,'adminGetLSGiaoDich']);
