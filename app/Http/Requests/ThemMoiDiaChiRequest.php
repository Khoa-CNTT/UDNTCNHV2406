<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemMoiDiaChiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_nguoi_nhan'    => "required|min:1|max:50",
            'so_dien_thoai'     => "required|digits:10",
            'dia_chi'           => "required",
        ];
    }

    public function messages()
    {
        return [
            'ten_nguoi_nhan.*'          => 'Tên người nhận không được bỏ trống, và phải ít hơn 50 ký tự',
            'so_dien_thoai.*'           => 'Số điện thoại không được bỏ trống và phải là 10 số',
            'dia_chi.*'                 => 'Địa chỉ không được bỏ trống',
        ];
    }
}
