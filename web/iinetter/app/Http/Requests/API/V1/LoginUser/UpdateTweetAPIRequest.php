<?php

namespace App\Http\Requests\API\V1\LoginUser;

use App\Models\Tweet;
use InfyOm\Generator\Request\APIRequest;

class UpdateTweetAPIRequest extends APIRequest
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
        $rules = [];
        $rules['favorite_count'] = Tweet::$rules['favorite_count'];
        
        return $rules;
    }
}
