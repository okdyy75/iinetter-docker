<?php

namespace App\Repositories;

use App\Models\UserProfile;
use App\Repositories\BaseRepository;

/**
 * Class UserProfileRepository
 * @package App\Repositories
 * @version December 30, 2020, 6:29 pm JST
*/

class UserProfileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'screen_name',
        'description',
        'location',
        'url',
        'icon',
        'header_image'
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
        return UserProfile::class;
    }
}
