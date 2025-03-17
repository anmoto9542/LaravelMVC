<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateProjectMembersReq extends FormRequest
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
            'projectId' => 'required|int|max:16',
            'member' => 'required|array', // 確保 member 是一個陣列
            'member.*' => 'required|numeric|max:999999', // 對陣列中的每個元素進行驗證
        ];
    }
}
