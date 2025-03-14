<?php

namespace App\Exception;

use App\Http\Enums\StatusCode;

class CustomException extends \Exception
{
    protected StatusCode $status;
    protected $message;
    public function __construct(StatusCode $status, string $message = null)
    {
        // 預設訊息使用 StatusCode 的訊息
        $message = $message ?? $status->getMessage();

        parent::__construct($message);

        // 設定狀態和訊息
        $this->status = $status;
        $this->message = $message;
    }

    // 取得狀態
    public function getStatus(): StatusCode
    {
        return $this->status;
    }

    // 取得訊息
    public function getMessageText(): string
    {
        return $this->message;
    }
}
