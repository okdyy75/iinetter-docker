<?php

namespace App\Repositories;

use App\Models\Tweet;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

/**
 * Class TweetRepository
 * @package App\Repositories
 * @version December 30, 2020, 3:32 pm JST
*/

class TweetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tweet_text'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tweet::class;
    }

    /**
     * ユーザーIDからtweet検索
     *
     * @return Collection
     */
    public function fetchAllByUserId(int $userId): Collection
    {
        return $this->model
            ->with('user.userProfile', 'refTweet.user.userProfile')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();
    }
}
