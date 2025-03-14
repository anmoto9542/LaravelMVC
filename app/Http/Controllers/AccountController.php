<?php

namespace App\Http\Controllers;

use App\Exception\CustomException;
use App\Http\Enums\StatusCode;
use App\Http\Requests\CreateAccountReq;
use App\Http\Requests\DeleteAccountReq;
use App\Http\Requests\UpdateAccountReq;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;

class AccountController extends BaseController
{
    private AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        parent::__construct();
        $this->accountService = $accountService;
    }

    /**
     * 建立帳戶
     *
     * @param CreateAccountReq $request
     * @return JsonResponse
     */
    public function register(CreateAccountReq $request): JsonResponse
    {
        try {
            // 呼叫 Service 建立帳戶
            $this->accountService->register($request);

        } catch (CustomException $ce) {
            return self::apiRespError($ce->getStatus());
        } catch (\Exception $e) {
            return self::apiRespError(StatusCode::ERROR_1);
        }

        return self::apiResp("帳戶建立成功！");
    }

    /**
     * 變更帳戶
     * @param UpdateAccountReq $request
     * @return JsonResponse
     */
    public function updateAccount(UpdateAccountReq $request): JsonResponse
    {
        try {
            // 呼叫 Service 更新帳戶資訊
            $this->accountService->updateAccount($request);

        } catch (CustomException $ce) {
            return self::apiRespError($ce->getStatus());
        } catch (\Exception $e) {
            return self::apiRespError(StatusCode::ERROR_1);
        }

        return self::apiResp("帳戶更新成功！");
    }


    /**
     * 刪除帳戶
     * @param DeleteAccountReq $request
     * @return JsonResponse
     */
    public function deleteAccount(DeleteAccountReq $request): JsonResponse
    {
        try {
            // 呼叫 Service 刪除帳戶
            $this->accountService->deleteAccount($request);


        } catch (CustomException $ce) {
            return self::apiRespError($ce->getStatus());
        } catch (\Exception $e) {
            return self::apiRespError(StatusCode::ERROR_1);
        }

        return self::apiResp("刪除帳戶成功！");
    }

}
