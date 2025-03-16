<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponseResource;
use App\Http\Enums\StatusCode;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public string $code;
    public string $message;
    public string $authToken;

    public mixed $data;

    // 設定預設值
    public function __construct(
        string $code = "00000",
        string $message = "Success!!",
        string $authToken = "",
        mixed  $data = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->authToken = $authToken;
        $this->data = $data;
    }

    /**
     * 成功回傳結果（有內容）
     */
    public static function apiResp(mixed $data): JsonResponse
    {
        return self::apiRespFinal($data, StatusCode::SUCCESS->value, StatusCode::SUCCESS->getMessage(), "");
    }

    /**
     * 成功回傳結果（空內容）
     */
    public static function apiRespEmpty(StatusCode $statusCode): JsonResponse
    {
        return self::apiRespFinal(null, $statusCode->value, $statusCode->getMessage(), "");
    }

    /**
     * 錯誤回傳
     */
    public static function  apiRespError(StatusCode $statusCode): JsonResponse
    {
        return self::apiRespFinal(null, $statusCode->value, $statusCode->getMessage(), "");
    }

    /**
     * 登入 API，帶 Token 回傳
     */
    public static function apiRespWithToken(mixed $data, StatusCode $statusCode, string $token): JsonResponse
    {
        return self::apiRespFinal($data, $statusCode->value, $statusCode->getMessage(), $token);
    }

    /**
     * 統一回傳 JSON
     */
    private static function apiRespFinal(mixed $data, string $code, string $message, string $token): JsonResponse
    {
        $responseData = [
            'data' => $data,
            'status' => $code,
            'message' => $message,
            'auth_token' => $token,
        ];

        // 使用 ApiResponseResource 來處理回應
        return new JsonResponse(ApiResponseResource::make($responseData));
    }
}
