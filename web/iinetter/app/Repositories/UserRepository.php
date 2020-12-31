<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version December 30, 2020, 7:59 am JST
 */

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email'
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
        return User::class;
    }

    /**
     * ユーザー名から検索
     *
     * @param int $id
     * @return User
     */
    public function findById(int $id): User
    {
        return $this->model
            ->with([
                'userProfile'
            ])
            ->find($id);
    }

    /**
     * ユーザー名から検索
     *
     * @param string $name
     * @return User
     */
    public function findByName(string $name): User
    {
        return $this->model
            ->with([
                'userProfile',
                'tweets' => function ($query) {
                    $query->with([
                            'user.userProfile',
                            'refTweet.user.userProfile',
                            'refTweet.refTweet.user.userProfile',
                        ])
                        ->orderByDesc('created_at');
                },
            ])
            ->where('name', $name)
            ->first();
    }
}
