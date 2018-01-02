<?php

namespace App\Http\Requests\Backend\Category;

use App\Http\Requests\Request;

class CreateRequest extends Request
{
    /**
     * Determind if the user is the authorized to make the request.
     * 确定是否授权用户发出此请求。
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the valication rules that apply to the request
     * 获取适用于请求的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    /**
     * Get the message for the valication rule
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'=>'分类名不能为空',
        ];
    }

}