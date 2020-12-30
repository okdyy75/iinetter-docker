<?php namespace Tests\Repositories;

use App\Models\UserProfile;
use App\Repositories\UserProfileRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserProfileRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserProfileRepository
     */
    protected $userProfileRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userProfileRepo = \App::make(UserProfileRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_profile()
    {
        $userProfile = UserProfile::factory()->make()->toArray();

        $createdUserProfile = $this->userProfileRepo->create($userProfile);

        $createdUserProfile = $createdUserProfile->toArray();
        $this->assertArrayHasKey('id', $createdUserProfile);
        $this->assertNotNull($createdUserProfile['id'], 'Created UserProfile must have id specified');
        $this->assertNotNull(UserProfile::find($createdUserProfile['id']), 'UserProfile with given id must be in DB');
        $this->assertModelData($userProfile, $createdUserProfile);
    }

    /**
     * @test read
     */
    public function test_read_user_profile()
    {
        $userProfile = UserProfile::factory()->create();

        $dbUserProfile = $this->userProfileRepo->find($userProfile->id);

        $dbUserProfile = $dbUserProfile->toArray();
        $this->assertModelData($userProfile->toArray(), $dbUserProfile);
    }

    /**
     * @test update
     */
    public function test_update_user_profile()
    {
        $userProfile = UserProfile::factory()->create();
        $fakeUserProfile = UserProfile::factory()->make()->toArray();

        $updatedUserProfile = $this->userProfileRepo->update($fakeUserProfile, $userProfile->id);

        $this->assertModelData($fakeUserProfile, $updatedUserProfile->toArray());
        $dbUserProfile = $this->userProfileRepo->find($userProfile->id);
        $this->assertModelData($fakeUserProfile, $dbUserProfile->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_profile()
    {
        $userProfile = UserProfile::factory()->create();

        $resp = $this->userProfileRepo->delete($userProfile->id);

        $this->assertTrue($resp);
        $this->assertNull(UserProfile::find($userProfile->id), 'UserProfile should not exist in DB');
    }
}
