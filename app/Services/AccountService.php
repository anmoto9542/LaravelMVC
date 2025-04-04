<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Exception\CustomException;
use App\Http\Enums\StatusCode;
use App\Http\Requests\CreateAccountReq;
use App\Http\Requests\DeleteAccountReq;
use App\Http\Requests\UpdateAccountReq;
use App\Models\User;

class AccountService
{
    /**
     * 建立帳戶
     * @param CreateAccountReq $req
     * @return JsonResponse
     * @throws CustomException
     */
    public function register(CreateAccountReq $req): JsonResponse
    {
        try {
            // 檢查帳號是否已存在
            $user = User::where('email', $req->email)
                ->where('isDeleted', false)
                ->first();

            if ($user) {
                throw new CustomException(StatusCode::ERROR_2);
            }


            $now = now();
            // 上傳圖片
            $imagePath = '';
            if ($req->avatar && $req->avatar->isValid()) {
                $imageName = 'profile_' . time() . '.' . $req->avatar->getClientOriginalExtension();
                $imagePath = $req->avatar->storeAs('profile_pictures', $imageName, 'public');
            }

            // 建立新帳戶
            User::create([
                'email' => $req->email,
                'password' => Hash::make($req->password), // Laravel 內建密碼 Hash
                'name' => $req->name,
                'avatar' => $imagePath,
                'status' => 1,
                'sysadmin' => 0,
                'isDeleted' => false,
                'createdTime' => $now,
                'updatedTime' => $now,
            ]);
            return response()->json([]);

        } catch (CustomException $ce) {
            throw $ce;
        } catch (\Exception $e) {
            Log::error("createAccount error: ", ['error' => $e->getMessage()]);
            throw new CustomException(StatusCode::ERROR_1);
        }

    }

    /**
     * 更新帳戶密碼/圖片
     * @param UpdateAccountReq $req
     * @return JsonResponse
     * @throws CustomException
     */
    public function updateAccount(UpdateAccountReq $req): JsonResponse
    {
        try {
            $user = User::find($req->email);

            if ($user) {
                // 更新密碼
                if (!empty($req->password)) {
                    $user->password = Hash::make($req->password);
                }
                // 更換圖片
                if ($req->hasFile('avatar') && $req->avatar->isValid()) {
                    // 刪除舊圖片
                    if ($user->Avatar && Storage::disk('public')->exists('profile_pictures/' . $user->Avatar)) {
                        Storage::disk('public')->delete('profile_pictures/' . $user->Avatar);
                    }
                    // 儲存新圖片
                    $imageName = 'profile_' . time() . '.' . $req->avatar->getClientOriginalExtension();
                    $req->avatar->storeAs('profile_pictures', $imageName, 'public');

                    // 更新帳號的 Avatar 欄位
                    $user->Avatar = $imageName;
                }

                // 更新時間
                $user->updated_time = now();

                $user->save();
            } else {
                throw new CustomException(StatusCode::ERROR_3);
            }
            return response()->json([]);
        } catch (CustomException $ce) {
            throw $ce;
        } catch (\Exception $e) {
            Log::error("updateAccount error: ", ['error' => $e->getMessage()]);
            throw new CustomException(StatusCode::ERROR_1);
        }

    }

    /**
     * 刪除帳戶
     * @param DeleteAccountReq $req
     * @return JsonResponse
     * @throws CustomException
     */
    public function deleteAccount(DeleteAccountReq $req): JsonResponse
    {
        try {
            $user = User::find($req->email);
            if ($user) {
                // 刪除大頭貼
                if ($user->Avatar && Storage::disk('public')->exists('profile_pictures/' . $user->Avatar)) {
                    Storage::disk('public')->delete('profile_pictures/' . $user->Avatar);
                }
                // 將帳號刪除狀態設定為true
                $user->IsDeleted = true;
                // 更新時間
                $user->updated_time = now();

                $user->save();

                return response()->json([]);
            } else {
                throw new CustomException(StatusCode::ERROR_3);
            }

        } catch (CustomException $ce) {
            throw $ce;
        } catch (\Exception $e) {
            Log::error("updateAccount error: ", ['error' => $e->getMessage()]);
            throw new CustomException(StatusCode::ERROR_1);
        }
    }
}
