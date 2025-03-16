<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetLoginResultVo extends JsonResource
{
    // 定義屬性並設置為 protected
    protected string $authToken;
    protected LoginInfoVo $loginInfoVo;

    // 構造方法，傳遞 authToken 和 loginInfoVo
    public function __construct($resource, $authToken, $loginInfoVo)
    {
        parent::__construct($resource);
        $this->authToken = $authToken;
        $this->loginInfoVo = $loginInfoVo;
    }

    /**
     * Transform the resource into an array.
     * //     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'authToken' => $this->authToken,
            'loginInfoVo' => $this->loginInfoVo,
        ];
    }

}
