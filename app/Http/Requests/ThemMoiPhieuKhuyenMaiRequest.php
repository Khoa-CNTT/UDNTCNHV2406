<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemMoiPhieuKhuyenMaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ma_khuyen_mai'         => 'required|unique:phieu_khuyen_mais,ma_khuyen_mai',
            'ngay_bat_dau'          => 'required',
            'ngay_ket_thuc'         => 'required',
            'tinh_trang'            => 'required|between:0,1',
        ];
    }

    public function messages()
    {
        return [
            'ma_khuyen_mai.*'       => 'Họ và tên không được để trống, từ 4 đến 100 ký tự',
            'ngay_bat_dau.*'        => 'Email không được để trống, hoặc đã tồn tại',
            'ngay_ket_thuc.*'       => 'Số điẹn thoại không được để trống và phải có 10 số',
            'tinh_trang.*'          => 'Mật khẩu không được để trống và từ 6 đến 30 ký tự',
        ];
    }
}
