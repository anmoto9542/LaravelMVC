<?php

namespace App\Http\Enums;

enum StatusCode: string
{
    case SUCCESS = '0000';
    case ERROR_1 = '9999';
    case ERROR_2 = '9001';
    case ERROR_3 = '9002';
    case ERROR_4 = '9003';
    case ERROR_5 = '9004';
    case ERROR_6 = '9005';

    public function getMessage(): string
    {
        return match ($this) {
            self::SUCCESS => '成功',
            self::ERROR_1 => '系統錯誤',
            self::ERROR_2 => '帳戶已存在',
            self::ERROR_3 => '帳戶資訊錯誤',
            self::ERROR_4 => '登入驗證錯誤，請再次確認登入帳號密碼',
            self::ERROR_5 => '成員ID不存在,請再次確認',
            self::ERROR_6 => '專案ID不存在,請再次確認',
        };
    }
}
