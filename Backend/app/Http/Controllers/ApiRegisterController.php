<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ApiRegisterRequest;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Support\Facades\Log;

class ApiRegisterController extends Controller
{
    //
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(ApiRegisterRequest $request)
    {

       $this->user->create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'phone' => $request->phone,
            'role_id' => $request->role_id
       ]);

        try{
            return response()->json([
                'code' => 200,
                'message' => 'success',
            ], 200);
        }catch(\Exception $exception){
            Log::error('Message: '. $exception->getMessage() . 'line : '. $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail',
            ], 500);
        }
    }
}
