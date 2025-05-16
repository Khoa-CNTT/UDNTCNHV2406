<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DangKyNguoiDungRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

             'ho_ten'    => 'required|string',
             'email'     => 'required|email|unique:hoc_viens,email,' . $this->id,
             'password'  => 'required',
             'ngay_sinh' => 'required|date|before:today',
             'gioi_tinh' => 'required',
             'so_cccd'   => 'required|unique:hoc_viens,so_cccd,' . $this->id,
             'sdt'       => 'required|digits:10|unique:hoc_viens,sdt,' . $this->id,
             'dia_chi'   => 'required',

        ];
    }
    public function messages(): array
{
    return [
        'email.required'    => 'Vui lòng nhập email học viên.',
        'email.email'       => 'Email học viên không đúng định dạng.',
        'email.unique'      => 'Email học viên đã tồn tại.',

        'password.required' => 'Vui lòng nhập mật khẩu học viên.',

        'ho_ten.required'   => 'Vui lòng nhập họ tên học viên.',
        'ho_ten.string'     => 'Họ tên học viên không hợp lệ.',

        'ngay_sinh.required'=> 'Vui lòng nhập ngày sinh học viên.',
        'ngay_sinh.before'  => 'Ngày sinh học viên phải nhỏ hơn ngày hiện tại.',

        'gioi_tinh.required'=> 'Vui lòng chọn giới tính học viên.',

        'so_cccd.required'  => 'Vui lòng nhập số CCCD học viên.',
        'so_cccd.unique'    => 'Số CCCD học viên đã tồn tại.',

        'sdt.required'      => 'Vui lòng nhập số điện thoại học viên.',
        'sdt.digits'        => 'Số điện thoại học viên phải đúng 10 chữ số.',
        'sdt.unique'        => 'Số điện thoại học viên đã tồn tại.',

        'dia_chi.required'  => 'Vui lòng nhập địa chỉ học viên.',
    ];
}

}
