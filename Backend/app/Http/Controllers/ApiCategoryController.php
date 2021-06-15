<?php

namespace App\Http\Controllers;

use App\Traits\DeleteModelTrait;
use Illuminate\Http\Request;
use App\Models\Category;

class ApiCategoryController extends Controller
{
    //
    use DeleteModelTrait;
    private $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $category = $this->category->latest()->get();
        return response()->json($category);
    }
    public function create(Request $request)
    {
        $this->category->create([
            'name' => $request->name,
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

    public function edit($id)
    {
        $category = $this->category->find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $this->category->find($id)->update([
            'name' => $request->name,
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
        return $this->deleteModelTrait($id, $this->category);
    }

}
