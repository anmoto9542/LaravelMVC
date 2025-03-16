<?php

namespace App\Http\Controllers;

use App\Exception\CustomException;
use App\Http\Enums\StatusCode;
use App\Http\Requests\LoginReq;
use App\Services\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    private LoginService $loginService;
    public function __construct(LoginService $loginService) {
        parent::__construct();
        $this->loginService = $loginService;
    }

    /**
     * 使用者登入
     */
    public function login(LoginReq $request): JsonResponse
    {
        try {
            $resultVo = $this->loginService->login($request);
            $dataResult = json_decode($resultVo->getContent(), true);

            return self::apiRespWithToken(
                $dataResult['loginInfoVo'],
                StatusCode::SUCCESS,
                $dataResult['authToken']
            );
        } catch (CustomException $e) {
            return self::apiRespError($e->getStatus());
        } catch (\Exception $e) {
            return self::apiRespError(StatusCode::ERROR_1);
        }
    }

    /**
     * 登出
     */
    public function logout(): JsonResponse
    {
        try {
            Auth::user()->tokens()->delete();
            return self::apiResp("使用者成功登出！");
        } catch (\Exception $e) {
            return self::apiRespError(StatusCode::ERROR_1);
        }
    }

}
