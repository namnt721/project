<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiPermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApiPermissionController extends Controller
{
    //
    private $permission;
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function getPermission()
    {
        $permission = config('permission.table_module');

        return response()->json($permission);
    }

    public function store(ApiPermissionRequest $request)
    {
        $permission = $this->permission->create([
            'name' => $request->name,
            'display_name' => $request->name,
            'parent_id' => 0,
            'key_code' => 0,
        ]);

        foreach($request->role as $role)
        {
            $this->permission->create([
                'name' => $role .' '. $request->name,
                'display_name' => $role .' '. $request->name,
                'parent_id' => $permission->id,
                'key_code' => Str::slug($role) . '-' . Str::slug($request->name),
            ]);
        }
        $data = $this->permission->with('rolesChildrent')->find($permission->id);
        try{
            return response()->json([
                'data' => $data,
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

    public function delete($id)
    {

        try{
            $this->permission->find($id)->delete();
            $this->permission->with('rolesChildrent')->where('parent_id', $id)->delete();
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
