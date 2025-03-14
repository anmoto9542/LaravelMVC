<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TokenService
{
    public function generateToken(User $user): String
    {
        $token = auth()->attempt( [
            'email' => $user -> Email,
            'password' => $user -> Password,
        ]);

        if (!$token) {
            throw new \Exception('Token 建立失敗');
        }

        return $token;
    }

//    public function createNewToken($token){
//        return response()->json([
//            'access_token' => $token,
//            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60,
//            'user' => auth()->user()
//        ]);
//    }
}
