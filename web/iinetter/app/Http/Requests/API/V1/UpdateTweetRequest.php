<?php

namespace App\Http\Requests\API\V1;

use App\Models\Tweet;
use InfyOm\Generator\Request\APIRequest;

class UpdateTweetRequest extends APIRequest
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
        $rules['reply_count'] = Tweet::$rules['reply_count'];
        $rules['retweet_count'] = Tweet::$rules['retweet_count'];
        $rules['favorite_count'] = Tweet::$rules['favorite_count'];
        
        return $rules;
    }
}
