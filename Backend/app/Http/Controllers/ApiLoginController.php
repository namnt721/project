<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLoginController extends Controller
{

    public function login(ApiLoginRequest $request)
    {
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $user = User::where('email', $request->email)->first();
            $user->token = $user->createToken('Token Name')->accessToken;
            return response()->json($user);
        }else{
            return response()->json('Bạn nhập sai tên đăng nhập hoặc mật khẩu', 401);
        }
    }
}
