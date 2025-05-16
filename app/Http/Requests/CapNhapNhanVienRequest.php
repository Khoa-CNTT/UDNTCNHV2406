<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhapNhanVienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'                    => 'required|exists:nhan_viens,id',
            'ho_va_ten'             => 'required|min:4|max:100',
            'email'                 => 'required|email|unique:nhan_viens,email,'. $this->id,
            'so_dien_thoai'         => 'required|digits:10',
            'dia_chi'               => 'required',
            'tinh_trang'            => 'required|between:0,1',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                      => 'Nhân Viên phải tồn tại trong hệ thống!',
            'ho_va_ten.*'               => 'Họ và tên không được để trống, từ 4 đến 100 ký tự',
            'email.required'          => 'Email không được để trống',
            'email.email'             => 'Email không đúng định dạng',
            'email.unique'            => 'Email đã tồn tại',
            'so_dien_thoai.*'           => 'Số điẹn thoại không được để trống và phải có 10 số',
            'dia_chi'                   => 'Địa chỉ không được để trống',
            'tinh_trang'                => 'Tình trạng không được để trống',
        ];
    }
}
