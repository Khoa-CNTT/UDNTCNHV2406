<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChiTietPhanQuyenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_quyen'      => 'required|exists:phan_quyens,id',
            'id_chuc_nang'  => 'required|exists:chuc_nangs,id',
        ];
    }
}
