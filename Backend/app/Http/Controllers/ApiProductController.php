<?php

namespace App\Http\Controllers;

use App\Traits\DeleteModelTrait;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ApiProductController extends Controller
{
    //
    use DeleteModelTrait;
    private $product, $category;

    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    public function index(){
        $product = $this->product->with('category')->get();
        return response()->json($product);
    }

    public function create()
    {
        $category = $this->category->all();
        return response()->json($category);
    }

    public function store(Request $request)
    {

        $dataProduct = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'user_id' => 1,
            'quantity' => $request->quantity,
            'price' => $request->price
        ];

        if($request->hasFile('file')){
            $file = $request->file;
            $fileNameOrigin = $file->getClientOriginalName();
            $fileNameHash = Str::random(10).'.'.$file->getClientOriginalExtension();
            $file_path = $request->file('file')->storeAs('public/product/1', $fileNameHash);

            $dataUploadImage = [
                'file_name' => $fileNameOrigin,
                'file_path' => Storage::url($file_path)
            ];
        }
        if(!empty($dataUploadImage)){
            $dataProduct['feature_image_name'] = $dataUploadImage['file_name'];
            $dataProduct['feature_image_path'] = $dataUploadImage['file_path'];
        }

        $this->product->create($dataProduct);

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
        $category = $this->category->all();
        $product = $this->product->find($id);
        return response()->json([
            'product' => $product,
            'category' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $dataProductUpdate = [
          'name' => $request->name,
          'category_id' => $request->category_id,
          'quantity' => $request->quantity,
          'price' => $request->price,
        ];

        if($request->hasFile('file')){
            $file = $request->file;
            $fileNameOrigin = $file->getClientOriginalName();
            $fileNameHash = Str::random(10).'.'.$file->getClientOriginalExtension();
            $file_path = $request->file('file')->storeAs('public/product/1', $fileNameHash);

            $dataUploadImage = [
                'file_name' => $fileNameOrigin,
                'file_path' => Storage::url($file_path)
            ];
        }

        if(!empty($dataUploadImage)){
            $dataProductUpdate['feature_image_name'] = $dataUploadImage['file_name'];
            $dataProductUpdate['feature_image_path'] = $dataUploadImage['file_path'];
        }

        $this->product->find($id)->update($dataProductUpdate);

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

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->product);

    }
}
