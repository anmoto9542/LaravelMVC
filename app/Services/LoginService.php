<?php

namespace App\Services;

use App\Exception\CustomException;
use App\Http\Enums\StatusCode;
use App\Http\Requests\LoginReq;
use App\Http\Resources\GetLoginResultVo;
use App\Http\Resources\LoginInfoVo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginService
{
    private TokenService $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * 登入並回傳Token
     * @param LoginReq $loginReq
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomException
     */
    public function login(LoginReq $loginReq)
    {
        try {
            // 查詢帳號
            $accountEntity = User::where('Email', $loginReq->email)
                ->where('IsDeleted', false)
                ->first();

            // 檢查帳號是否存在
            if (!$accountEntity) {
                throw new CustomException(StatusCode::ERROR_4);
            } else {
                // 檢查密碼
                $password = $accountEntity->password;
                $reqPassword = $loginReq->password;

                if (Hash::check($reqPassword, $password)) {
                    // 生成 Token
                    $token = $this->tokenService->generateToken($accountEntity);

                    // 設定登入結果資料
                    $infoVo = new LoginInfoVo(
                        null,
                        $accountEntity->AccountID,
                        $accountEntity->Email,
                        $accountEntity->Name,
                        $accountEntity->Avatar,
                        $accountEntity->Sysadmin);

                    $resultVo = new GetLoginResultVo(null, $token, $infoVo);
//                    $resultVo = new GetLoginResultVo(null, null, $infoVo);

                    return response()->json($resultVo);
                } else {
                    throw new CustomException(StatusCode::ERROR_4);
                }
            }
        } catch (CustomException $e) {
            Log::error($e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new CustomException(StatusCode::ERROR_1);
        }
    }

}
