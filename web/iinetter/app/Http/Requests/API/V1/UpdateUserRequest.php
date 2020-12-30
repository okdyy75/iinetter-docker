<?php

namespace App\Http\Requests\API\V1;

use App\Models\User;
use InfyOm\Generator\Request\APIRequest;

class UpdateUserRequest extends APIRequest
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
        $rules['name'] = $rules['name'].",".$this->route("user");
        $rules['email'] = $rules['email'].",".$this->route("user");
        $rules['password'] = str_replace('required', 'nullable', $rules['password']);
        return $rules;
    }
}