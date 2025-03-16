<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class GetProjectResultVo extends JsonResource
{
    // 定義屬性
    protected int $id;
    protected int $customerId;
    protected int $code;
    protected string $name;
    protected string $remark;
    protected int $updateUser;
    protected $updateTime;
//    protected $roleList;
//    protected $memberList;

    // 構造方法，將資料傳遞進來
    public function __construct($resource, $projectId, $customerId, $projectCode, $name, $remark, $updateUser, $updateTime)
    {
        parent::__construct($resource);
        // 初始化屬性
        $this->id = $projectId;
        $this->customerId = $customerId;
        $this->code = $projectCode;
        $this->name = $name;
        $this->remark = $remark;
        $this->updateUser = $updateUser;
        $this->updateTime = Carbon::parse($updateTime);
//        $this->roleList = is_array($roleList) ? $roleList : [];
//        $this->memberList = is_array($memberList) ? array_map('intval', $memberList) : [];
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'projectId' => $this->id,
            'projectCode' => $this->code,
            'projectName' => $this->name,
            'lastUpdatedUser' => $this->updateUser,
            'lastUpdatedTime' => $this->updateTime,
            'roleList' => $this->roleList,
            'memberList' => $this->memberList,
        ];
    }
}
