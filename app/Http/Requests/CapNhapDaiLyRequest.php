<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhapDaiLyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'                    => 'required|exists:dai_lys,id',
            'ho_va_ten'             => 'required|min:4|max:100',
            'email'                 => 'required|email|unique:dai_lys,email,'. $this->id,
            'so_dien_thoai'         => 'required|digits:10',
            'password'              => 'required|min:6|max:50',
            'ten_doanh_nghiep'      => 'required',
            'ma_so_thue'            => 'required',
            'dia_chi_kinh_doanh'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                    => 'Đại lý phải tồn tại trong hệ thống!',
            'ho_va_ten.*'             => 'Họ và tên không được để trống, từ 4 đến 100 ký tự',
            'email.required'          => 'Email không được để trống',
            'email.email'             => 'Email không đúng định dạng',
            'email.unique'            => 'Email đã tồn tại',
            'so_dien_thoai.*'         => 'Số điẹn thoại không được để trống và phải có 10 số',
            'password.*'              => 'Mật khẩu không được để trống và từ 6 đến 30 ký tự',
            'ten_doanh_nghiep.*'      => 'Tên doanh nghiệp không được để trống',
            'ma_so_thue.*'            => 'Mã số thuế không được để trống',
            'dia_chi_kinh_doanh.*'    => 'Địa chỉ kinh doanh không được để trống',
        ];
    }
}
