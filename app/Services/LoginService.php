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
use Illuminate\Support\Facades\Redis;

class LoginService
{
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
            $user = User::where('Email', $loginReq->email)
                ->where('IsDeleted', false)
                ->first();

            // 檢查帳號是否存在
            if (!$user) {
                throw new CustomException(StatusCode::ERROR_4);
            }

            // 檢查密碼
            $password = $user->password;
            $reqPassword = $loginReq->password;
            if (Hash::check($reqPassword, $password)) {
                // 生成 Token
                $token = $user->createToken('apiToken')->plainTextToken;

                // 設定登入結果資料
                $infoVo = new LoginInfoVo(
                    null,
                    $user->id,
                    $user->email,
                    $user->name,
                    $user->avatar,
                    $user->sysadmin);

                $resultVo = new GetLoginResultVo(null, $token, $infoVo);

                Redis::setex('user_token' . $user->id, 3600, $token);

                return response()->json($resultVo);
            } else {
                throw new CustomException(StatusCode::ERROR_4);
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
