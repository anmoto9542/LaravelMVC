<?php

namespace App\Services;


use App\Events\MemberJoinedProject;
use App\Exception\CustomException;
use App\Http\Enums\StatusCode;
use App\Http\Requests\CreateProjectReq;
use App\Http\Requests\updateProjectMembersReq;
use App\Http\Resources\GetProjectResultVo;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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

    // 新增專案
    public function createProject(CreateProjectReq $req): JsonResponse
    {
        try {
            $now = now();
            // 設定生成 6 碼數字的範圍
            do {
                $randomNumber = mt_rand(100000, 999999); // 生成 6 位數的隨機數字
            } while (DB::table('Projects')->where('code', $randomNumber)->exists());

            // 建立新專案
            $project = Project::create([
                'customerId' => auth()->id(),
                'name' => $req->input('name'),
                'remark' => $req->input('remark'),
                'code' => $randomNumber,
                'isDeleted' => false,
                'status' => 1,
                'createUser' => auth()->id(),
                'createdTime' => $now,
                'updateUser' => auth()->id(),
                'updatedTime' => $now,
            ]);

            // 新增專案成員
            foreach ($req->input('members') as $member) {
                $user = User::where('id', $member)->first();
                if (!$user) {
                    throw new CustomException(StatusCode::ERROR_5);
                }

                ProjectMember::create([
                    'memberId' => $member,
                    'projectId' => $project->id,
                    'status' => 1,
                    'createUser' => auth()->id(),
                    'createdTime' => $now,
                    'updateUser' => auth()->id(),
                    'updatedTime' => $now,
                ]);

                //告知郵件
                event(new MemberJoinedProject($user));
            }

            return response()->json([]);
        } catch (CustomException $e) {
            Log::error($e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new CustomException(StatusCode::ERROR_1);
        }
    }

    // 新增專案成員
    public function updateProjectMembers(updateProjectMembersReq $req): JsonResponse
    {
        try {
            $now = now();
            $project = Project::find($req->projectId);
            if (!$project) {
                throw new CustomException(StatusCode::ERROR_6);
            }

            foreach ($req->input('members') as $member) {
                $user = User::where('id', $member)->first();
                if (!$user) {
                    throw new CustomException(StatusCode::ERROR_5);
                }
                ProjectMember::create([
                    'memberId' => $member,
                    'projectId' => $req->projectId,
                    'status' => 1,
                    'createUser' => auth()->id(),
                    'createdTime' => $now,
                    'updateUser' => auth()->id(),
                    'updatedTime' => $now,
                ]);
                //告知郵件
                event(new MemberJoinedProject($user));
            }

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
