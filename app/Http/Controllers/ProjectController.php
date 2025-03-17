<?php

namespace App\Http\Controllers;


use App\Exception\CustomException;
use App\Http\Enums\StatusCode;
use App\Http\Requests\CreateProjectReq;
use App\Http\Requests\updateProjectMembersReq;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class ProjectController extends BaseController
{
    private ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        parent::__construct();
        $this->projectService = $projectService;
    }

    /**
     * 取得專案列表
     * @return JsonResponse
     */
    public function getProjectData(): JsonResponse
    {
        try {
            // 取得登入的使用者
            $user = auth()->user();
            // 呼叫 Service 建立帳戶
            $resultVo = $this->projectService->getProjectData($user);
            $dataResult = json_decode($resultVo->getContent(), true);
            $token = Redis::get("user_token" . auth()->id());

            return self::apiRespWithToken(
                $dataResult,
                StatusCode::SUCCESS,
                $token
            );
        } catch (CustomException $ce) {
            return self::apiRespError($ce->getStatus());
        } catch (\Exception $e) {
            return self::apiRespError(StatusCode::ERROR_1);
        }
    }

    /**
     * 新增專案
     * @param CreateProjectReq $req
     * @return JsonResponse
     */
    public function createProject(CreateProjectReq $req): JsonResponse
    {
        try {
            $this->projectService->createProject($req);

        } catch (CustomException $ce) {
            return self::apiRespError($ce->getStatus());
        } catch (\Exception $e) {
            return self::apiRespError(StatusCode::ERROR_1);
        }
        return self::apiResp("專案新增成功！");
    }

    /**
     * 新增專案成員
     * @param updateProjectMembersReq $req
     * @return JsonResponse
     */
    public function updateProjectMembers(updateProjectMembersReq $req): JsonResponse
    {
        try {
            $this->projectService->updateProjectMembers($req);

        } catch (CustomException $ce) {
            return self::apiRespError($ce->getStatus());
        } catch (\Exception $e) {
            return self::apiRespError(StatusCode::ERROR_1);
        }
        return self::apiResp("專案成員新增成功！");
    }

}
