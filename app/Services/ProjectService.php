<?php

namespace App\Services;


use App\Events\MemberJoinedProject;
use App\Exception\CustomException;
use App\Http\Enums\StatusCode;
use App\Http\Requests\CreateProjectReq;
use App\Http\Requests\updateProjectMembersReq;
use App\Http\Resources\GetProjectResultVo;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProjectService
{
    // 取得專案列表
    public function getProjectData($user): JsonResponse
    {
        try {
            // 查詢該客戶的所有專案
            $projects = Project::where('customerId', $user->id)
                ->where('is_deleted', false) // 只篩選未被刪除的專案
                ->get();

            $resultVo = new GetProjectResultVo(
                null,
                $projects->id,
                $projects->customerId,
                $projects->code,
                $projects->name,
                $projects->remark,
                $projects->updateUser,
                $projects->updatedTime,
            );

            return response()->json($resultVo);
        } catch (CustomException $e) {
            Log::error($e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new CustomException(StatusCode::ERROR_1);
        }
    }


    public function createProject(CreateProjectReq $req): JsonResponse
    {
        try {


            return response()->json([]);
        } catch (CustomException $e) {
            Log::error($e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new CustomException(StatusCode::ERROR_1);
        }
    }

    public function updateProjectMembers(updateProjectMembersReq $req): JsonResponse
    {
        try {


            // 發送信件給被加入專案的成員
            $user = '';
            event(new MemberJoinedProject($user));

            return response()->json([]);
        } catch (CustomException $e) {
            Log::error($e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new CustomException(StatusCode::ERROR_1);
        }
    }

}
