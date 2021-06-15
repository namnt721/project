<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiRegisterRequest extends FormRequest
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
            //
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'required',
            'phone' => 'required|numeric|unique:users',

        ];


    }
    public function messages()
    {
        return [
            'email.required' => 'Email không được phép để trống!',
            'email.email' => 'Email bạn nhập không phải email!',
            'email.unique' => 'Email bạn nhập đã tồn tại!',
            'password.required' => 'Password không được phép để trống!',
            'name.required' => 'Họ và tên không được phép để trống!',
            'phone.required' => 'Số điện thoại không được phép để trống!',
            'phone.numeric' => 'Số điện thoại sai định dạng!',
            'phone.unique' => 'Số điện thoại đã tồn tại!',

        ];
    }
}
