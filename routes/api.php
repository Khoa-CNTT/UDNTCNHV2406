<?php

use App\Http\Controllers\AdminController;
use Illuminate\Routing\Route;

Route::post('/admin/dang-nhap', [AdminController::class,'dangNhap']);
