<?php namespace Tests\APIs\LoginUser;

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserProfile;
use Illuminate\Http\UploadedFile;

class UserProfileApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_profile()
    {
        $user = User::factory()->create();
        $userProfile = UserProfile::factory()->make([
            'user_id' => $user->id,
        ])->toArray();
        $userProfile['icon'] = null;
        $userProfile['header_image'] = null;

        $this->response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/v1/user_profile', $userProfile
        );
        $userProfile['icon_url'] = 'http://localhost/images/user_icon_default.png';
        $userProfile['header_image_url'] = 'http://localhost/images/user_header_image_default.png';

        $this->assertApiResponse($userProfile);
    }

    /**
     * @test
     */
    public function test_read_user_profile()
    {
        $user = User::factory()->create();
        $userProfile = UserProfile::factory()->create([
            'user_id' => $user->id
        ]);

        $this->response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/v1/user_profile'
        );

        $this->assertApiResponse($userProfile->toArray());
    }
}
