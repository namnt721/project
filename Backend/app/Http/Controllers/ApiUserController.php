<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\DeleteModelTrait;

class ApiUserController extends Controller
{
    //
    use DeleteModelTrait;
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function index()
    {
        $user = $this->user->latest()->get();
        return response()->json($user);
    }

    public function edit($id)
    {
        $user = $this->user->find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $this->user->find($id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
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

    public function delete($id){
        return $this->deleteModelTrait($id, $this->user);
    }



}
