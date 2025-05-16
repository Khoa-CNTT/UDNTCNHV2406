<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhapDanhMucRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'                => 'required|exists:danh_mucs,id',
            'ten_danh_muc'      => 'required',
            'slug_danh_muc'     => 'required|unique:danh_mucs,slug_danh_muc,'. $this->id,
            'tinh_trang'        => 'required',
            'id_danh_muc_cha'   => 'required',
            'hinh_anh'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                      => 'Danh mục phải tồn tại trong hệ thống!',
            'ten_danh_muc.*'            => 'Tên danh mục không được để trống',
            'slug_danh_muc.required'    => 'Slug danh mục không được để trống',
            'slug_danh_muc.unique'      => 'Slug đã tồn tại!',
            'tinh_trang.*'              => 'Tình trạng không được để trống',
            'id_danh_muc_cha.*'         => 'Danh mục không được để trống',
            'hinh_anh.*'                => 'Hình ảnh không được để trống',
        ];
    }
}
