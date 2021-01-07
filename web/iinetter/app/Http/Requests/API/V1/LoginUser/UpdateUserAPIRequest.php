<?php

namespace App\Http\Requests\API\V1\LoginUser;

use App\Models\User;
use InfyOm\Generator\Request\APIRequest;

class UpdateUserAPIRequest extends APIRequest
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
        $rules = User::$rules;
        $rules['name'] = $rules['name'].",".auth('api')->id();
        $rules['email'] = $rules['email'].",".auth('api')->id();
        $rules['password'] = str_replace('required', 'nullable', $rules['password']);
        return $rules;
    }
}
