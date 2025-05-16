<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemMoiNhanVienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ho_va_ten'             => 'required|min:4|max:100',
            'email'                 => 'required|email|unique:dai_lys,email',
            'so_dien_thoai'         => 'required|digits:10',
            'password'              => 'required|min:6|max:50',
            'dia_chi'               => 'required',
            'tinh_trang'            => 'required|between:0,1',
            'id_quyen'              => 'required|exists:phan_quyens,id',
        ];
    }

    public function messages()
    {
        return [
            'ho_va_ten.*'               => 'Họ và tên không được để trống, từ 4 đến 100 ký tự',
            'email.*'                   => 'Email không được để trống, hoặc đã tồn tại',
            'so_dien_thoai.*'           => 'Số điẹn thoại không được để trống và phải có 10 số',
            'password.*'                => 'Mật khẩu không được để trống và từ 6 đến 30 ký tự',
            're_password.*'             => 'Nhập lại mật khẩu không trùng với mật khẩu',
            'dia_chi'                   => 'Địa chỉ không được để trống',
            'tinh_trang'                => 'Tình trạng không được để trống',
        ];
    }
}
