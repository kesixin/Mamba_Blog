<?php

namespace App\Http\Requests\Backend\Navigation;

use App\Http\Requests\Request;

class CreateRequest extends Request
{

    /**
     * Determine if the user is authorized to make the requests.
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
            'url' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '请输入导航名',
            'url.required' => '请输入URL'
        ];
    }

}