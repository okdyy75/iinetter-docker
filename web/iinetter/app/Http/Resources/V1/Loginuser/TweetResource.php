<?php

namespace App\Http\Resources\V1\Loginuser;

use Illuminate\Http\Resources\Json\JsonResource;

class TweetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'ref_tweet_id' => $this->ref_tweet_id,
            'tweet_type' => $this->tweet_type,
            'tweet_text' => $this->tweet_text,
            'reply_count' => $this->reply_count,
            'retweet_count' => $this->retweet_count,
            'favorite_count' => $this->favorite_count,
            'screen_favorite_count' => $this->screen_favorite_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
