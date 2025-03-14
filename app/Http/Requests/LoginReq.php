<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginReq extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => '請輸入電子郵件地址',
            'email.email' => '請輸入有效的電子郵件格式',
            'password.required' => '請輸入密碼',
            'password.min' => '密碼長度至少為 8 個字元',
        ];
    }
}
