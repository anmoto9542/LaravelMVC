<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectReq extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'projectName' => 'required|String|max:32',
            'remark' => 'required|String|max:255',
            'member' => 'required|array', // 確保 member 是一個陣列
            'member.*' => 'required|numeric|max:999999', // 對陣列中的每個元素進行驗證
        ];
    }

    public function messages(): array
    {
        return [
            'projectName.required' => '請輸入專案名稱',
            'projectName.max' => '名稱過長',
            'remark.required' => '請輸入專案敘述',
            'remark.max' => '敘述超過限制長度',
        ];
    }
}
