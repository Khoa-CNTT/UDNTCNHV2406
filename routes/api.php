<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoQuanXacThucController;
use App\Http\Controllers\HocVienController;
use App\Http\Controllers\ToChucCapChungChiController;
use App\Models\CoQuanXacThuc;
use Illuminate\Routing\Route;



Route::post('/admin/dang-ky', [AdminController::class,'dangKy']);

Route::post('/hoc-vien/dang-ky', [HocVienController::class,'dangKy']);

Route::post('/co-quan/dang-ky', [CoQuanXacThucController::class,'dangKy']);

Route::post('/to-chuc/dang-ky', [ToChucCapChungChiController::class,'dangKy']);
