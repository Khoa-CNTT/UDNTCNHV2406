<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucNangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('chuc_nangs')->delete();
        DB::table('chuc_nangs')->truncate();
        DB::table('chuc_nangs')->insert([
            [
                'ten_chuc_nang'             =>  'Thêm tài khoản nhân viên',
            ],
            [
                'ten_chuc_nang'             =>  'Đổi trạng thái tài khoản nhân viên',
            ],
            [
                'ten_chuc_nang'             =>  'Phân quyền',
            ],
            [
                'ten_chuc_nang'             =>  'Xóa quyền',
            ],
            [
                'ten_chuc_nang'             =>  'Thêm chức vụ',
            ],
            [
                'ten_chuc_nang'             =>  'Xóa chức vụ',
            ],
            [
                'ten_chuc_nang'             =>  'Cập nhật chức vụ',
            ],
        ]);
    }
}
