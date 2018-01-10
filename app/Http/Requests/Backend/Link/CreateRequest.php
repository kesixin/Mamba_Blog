<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 11:29
 */

namespace App\Http\Requests\Backend\Link;


use App\Http\Requests\Request;

class CreateRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'url' => 'required|url'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '友情链接名字不能为空',
            'url.required' => 'URL不能为空',
            'url.url' => '请输入合法的URL'
        ];
    }
}