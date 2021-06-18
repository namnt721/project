<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:products',
            'category_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được phép để trống!',
            'name.unique' => 'Sản phẩm đã tồn tại!',
            'category_id.required' => 'Danh mục không được phép để trống!',
            'quantity.required' => 'Số lượng không được phép để trống!',
            'price.required' => 'Giá không được phép để trống!',
            'quantity.numeric' => 'Số lượng sai định dạng!',
            'price.numeric' => 'Số lượng sai định dạng!',

        ];
    }
}
