<?php

namespace App\Http\Controllers\API\V1\LoginUser;

use App\Http\Requests\API\V1\LoginUser\UpdateUserAPIRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use Response;

/**
 * Class UserAPIController
 * @package App\Http\Controllers\API\V1
 */

class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/user",
     *      summary="Get a user.",
     *      tags={"LoginUser"},
     *      description="Get user",
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $id = auth('api')->id();

        /** @var User $user */
        $user = $this->userRepository->findById($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    /**
     * @param UpdateUserAPIRequest $request
     * @return Response
     *
     * @SWG\Patch(
     *      path="/user",
     *      summary="Update the specified User in storage",
     *      tags={"LoginUser"},
     *      description="Update User",
     *      produces={"application/json"},
     *      security={{"apiToken":{}}},
     *      @SWG\Parameter(
     *          name="name",
     *          description="name of User",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *          description="email of User",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          description="password of User",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      @SWG\Parameter(
     *          name="password_confirmation",
     *          description="password_confirmation of User",
     *          type="string",
     *          required=false,
     *          in="formData"
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(UpdateUserAPIRequest $request)
    {
        $id = auth('api')->id();

        $input = $request->only('name', 'email', 'password');

        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        if ($user->email === 'test@example.com') {
            // testユーザーは更新不可に
            return $this->sendError('This action is unauthorized.', 403);
        }

        if (isset($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse($user->toArray(), 'User updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/user",
     *      summary="Remove the specified User from storage",
     *      tags={"LoginUser"},
     *      description="Delete User",
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
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy()
    {
        $id = auth('api')->id();

        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        if ($user->email === 'test@example.com') {
            // testユーザーは削除不可に
            return $this->sendError('This action is unauthorized.', 403);
        }

        $user->delete();

        return $this->sendSuccess('User deleted successfully');
    }
}
