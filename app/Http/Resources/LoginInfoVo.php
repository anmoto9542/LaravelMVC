<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginInfoVo extends JsonResource
{
    // 定義屬性
    protected int $accountId;
    protected string $email;
    protected string $name;
    protected string $avatarUrl;
    protected int $role;

    // 構造方法，將資料傳遞進來
    public function __construct($resource, $accountId, $email, $name, $avatarUrl, $role)
    {
        parent::__construct($resource);
        // 初始化屬性
        $this->accountId = $accountId;
        $this->email = $email;
        $this->name = $name;
        $this->avatarUrl = $avatarUrl;
        $this->role = $role;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'accountId' => $this->accountId,
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->role,
            'avatarUrl' => $this->avatarUrl,
        ];
    }
}
