<?php

namespace App\Http\Controllers;

use App\Exception\CustomException;
use App\Http\Enums\StatusCode;
use App\Http\Requests\LoginReq;
use App\Services\LoginService;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    private LoginService $loginService;
    public function __construct(LoginService $loginService) {
        parent::__construct();
        $this->loginService = $loginService;
//        $this->middleware('auth:api', ['except' => ['login']]);
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
            auth()->logout();
            return self::apiResp("使用者成功登出！");
        } catch (\Exception $e) {
            return self::apiRespError(StatusCode::ERROR_1);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
//    public function refresh() {
//        return $this->createNewToken(auth()->refresh());
//    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
//    public function userProfile() {
//        return response()->json(auth()->user());
//    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
//    protected function createNewToken($token){
//        return response()->json([
//            'access_token' => $token,
//            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60,
//            'user' => auth()->user()
//        ]);
//    }
}
