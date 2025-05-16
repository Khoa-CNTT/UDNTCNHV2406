<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemMoiPhanQuyenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_quyen'             => 'required|min:1|max:100|unique:phan_quyens,ten_quyen',
        ];
    }

    public function messages()
    {
        return [
            'ten_quyen.*'               => 'Tên quyền không được để trống, nhỏ hơn 100 ký tự, và không được trùng',
        ];
    }
}
