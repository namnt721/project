<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRoleRequest;
use App\Models\PermissionRole;
use App\Traits\DeleteModelTrait;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiRoleController extends Controller
{
    //
    use DeleteModelTrait;
    private $role, $permission;

    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index(){
        $role = $this->role->get();

        return response()->json($role);
    }

    public function create()
    {
        $permission = $this->permission->where('parent_id', 0)->with('rolesChildrent')->get();

        return response()->json($permission);
    }

    public function store(ApiRoleRequest $request)
    {
        try{
            DB::beginTransaction();
            $role = $this->role->create([
                'name' => $request->name,
                'display_name' => $request->display_name,
            ]);
            $role->permissions()->attach($request->data_children);
            DB::commit();
            return response()->json([
                    'code' => 200,
                    'message' => 'success'
                ], 200);
        }
        catch(\Exception $exception){
            Log::error('Message: '. $exception->getMessage() . 'line : '. $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail',
            ], 500);
        }
    }

    public function edit($id)
    {
        $role = $this->role->with('permissions')->find($id);
        return response()->json($role);
    }

    public function update(Request $request, $id){
        try{
            DB::beginTransaction();
            $role = $this->role->find($id);
            $role->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
            ]);

            $role->permissions()->sync($request->data_children);

            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        }
        catch(\Exception $exception){
            Log::error('Message: '. $exception->getMessage() . 'line : '. $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail',
            ], 500);
        }
    }

    public function delete($id)
    {
        PermissionRole::where('role_id', $id)->delete($id);
        return $this->deleteModelTrait($id, $this->role);
    }
}
