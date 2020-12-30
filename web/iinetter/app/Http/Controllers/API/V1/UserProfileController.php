<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateUserProfileRequest;
use App\Http\Requests\API\V1\UpdateUserProfileRequest;
use App\Models\UserProfile;
use App\Repositories\UserProfileRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserProfileController
 * @package App\Http\Controllers\API\V1
 */

class UserProfileController extends AppBaseController
{
    /** @var  UserProfileRepository */
    private $userProfileRepository;

    public function __construct(UserProfileRepository $userProfileRepo)
    {
        $this->userProfileRepository = $userProfileRepo;
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/user_profile",
     *      summary="Display the specified UserProfile",
     *      tags={"UserProfile"},
     *      description="Get UserProfile",
     *      produces={"application/json"},
     *      security={{"apiToken":{}}},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/UserProfile"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index()
    {
        $id = auth('api')->user()->userProfile->id ?? null;

        /** @var UserProfile $userProfile */
        $userProfile = $this->userProfileRepository->find($id);

        if (empty($userProfile)) {
            return $this->sendError('User Profile not found');
        }

        return $this->sendResponse($userProfile->toArray(), 'User Profile retrieved successfully');
    }

    /**
     * @param CreateUserProfileAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/user_profile",
     *      summary="Store a newly created UserProfile in storage",
     *      tags={"UserProfile"},
     *      description="Store UserProfile",
     *      produces={"application/json"},
     *      security={{"apiToken":{}}},
     *      @SWG\Parameter(
     *          name="screen_name",
     *          in="formData",
     *          description="UserProfile screen_name",
     *          required=false,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="description",
     *          in="formData",
     *          description="UserProfile description",
     *          required=false,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="location",
     *          in="formData",
     *          description="UserProfile location",
     *          required=false,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="url",
     *          in="formData",
     *          description="UserProfile url",
     *          required=false,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="icon",
     *          in="formData",
     *          description="UserProfile icon file",
     *          required=false,
     *          type="file"
     *      ),
     *      @SWG\Parameter(
     *          name="header_image",
     *          in="formData",
     *          description="UserProfile header_image file",
     *          required=false,
     *          type="file"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/UserProfile"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateUserProfileRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth('api')->id();

        if (isset($input['icon'])) {
            $input['icon'] = $request->file('icon')->store('images/icons', 'public');
        }
        if (isset($input['header_image'])) {
            $input['header_image'] = $request->file('header_image')->store('images/header_images', 'public');
        }

        $id = auth('api')->user()->userProfile->id ?? null;

        /** @var UserProfile $userProfile */
        $findUserProfile = $this->userProfileRepository->find($id);

        if (empty($findUserProfile)) {
            $userProfile = $this->userProfileRepository->create($input);
        } else {
            $userProfile = $this->userProfileRepository->update($input, $id);
        }


        return $this->sendResponse($userProfile->toArray(), 'User Profile saved successfully');
    }
}
