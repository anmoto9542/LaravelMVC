<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginInfoVo extends JsonResource
{
    // 定義屬性
    protected int $id;
    protected string $email;
    protected string $name;
    protected string $avatarUrl;
    protected int $role;

    // 構造方法，將資料傳遞進來
    public function __construct($resource, $userId, $email, $name, $avatarUrl, $role)
    {
        parent::__construct($resource);
        // 初始化屬性
        $this->id = $userId;
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
            'userId' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->role,
            'avatarUrl' => $this->avatarUrl,
        ];
    }
}
