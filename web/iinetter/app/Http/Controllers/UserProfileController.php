<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Repositories\UserProfileRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class UserProfileController extends AppBaseController
{
    /** @var  UserProfileRepository */
    private $userProfileRepository;

    public function __construct(UserProfileRepository $userProfileRepo)
    {
        $this->userProfileRepository = $userProfileRepo;
    }

    /**
     * Display a listing of the UserProfile.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $userProfiles = $this->userProfileRepository->all();

        return view('user_profiles.index')
            ->with('userProfiles', $userProfiles);
    }

    /**
     * Show the form for creating a new UserProfile.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_profiles.create');
    }

    /**
     * Store a newly created UserProfile in storage.
     *
     * @param CreateUserProfileRequest $request
     *
     * @return Response
     */
    public function store(CreateUserProfileRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth('web')->id();

        if (isset($input['icon'])) {
            $input['icon'] = base64_encode($request->file('icon')->getContent());
        }
        if (isset($input['header_image'])) {
            $input['header_image'] = base64_encode($request->file('header_image')->getContent());
        }

        $userProfile = $this->userProfileRepository->create($input);

        Flash::success('User Profile saved successfully.');

        return redirect(route('userProfiles.index'));
    }

    /**
     * Display the specified UserProfile.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userProfile = $this->userProfileRepository->find($id);

        if (empty($userProfile)) {
            Flash::error('User Profile not found');

            return redirect(route('userProfiles.index'));
        }

        return view('user_profiles.show')->with('userProfile', $userProfile);
    }

    /**
     * Show the form for editing the specified UserProfile.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userProfile = $this->userProfileRepository->find($id);

        if (empty($userProfile)) {
            Flash::error('User Profile not found');

            return redirect(route('userProfiles.index'));
        }

        return view('user_profiles.edit')->with('userProfile', $userProfile);
    }

    /**
     * Update the specified UserProfile in storage.
     *
     * @param int $id
     * @param UpdateUserProfileRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserProfileRequest $request)
    {
        $userProfile = $this->userProfileRepository->find($id);

        if (empty($userProfile)) {
            Flash::error('User Profile not found');

            return redirect(route('userProfiles.index'));
        }

        $input = $request->all();
        if (isset($input['icon'])) {
            $input['icon'] = base64_encode($request->file('icon')->getContent());
        }
        if (isset($input['header_image'])) {
            $input['header_image'] = base64_encode($request->file('header_image')->getContent());
        }

        $userProfile = $this->userProfileRepository->update($input, $id);

        Flash::success('User Profile updated successfully.');

        return redirect(route('userProfiles.index'));
    }

    /**
     * Remove the specified UserProfile from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userProfile = $this->userProfileRepository->find($id);

        if (empty($userProfile)) {
            Flash::error('User Profile not found');

            return redirect(route('userProfiles.index'));
        }

        $this->userProfileRepository->delete($id);

        Flash::success('User Profile deleted successfully.');

        return redirect(route('userProfiles.index'));
    }
}
