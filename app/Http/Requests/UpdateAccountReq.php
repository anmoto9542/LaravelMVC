<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountReq extends FormRequest
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
            'email' => 'required|email',
            'password' => 'nullable|min:8',
            'avatar' => 'nullable|image|mimes:jpg,png|max:2048', // 限制檔案大小
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => '請輸入電子郵件地址',
            'email.email' => '請輸入有效的電子郵件格式',
            'password.required' => '請輸入密碼',
            'password.min' => '密碼長度至少為 8 個字元',
            'avatar.image' => '請上傳有效的圖片檔案',
            'avatar.mimes' => '圖片格式只支援 jpg, png',
            'avatar.max' => '圖片超過限制大小',
        ];
    }
}
