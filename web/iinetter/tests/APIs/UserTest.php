<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, RefreshDatabase;

    /**
     * @test
     */
    public function test_read_user()
    {
        $user = User::factory()->create();

        $this->response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/v1/user'
        );

        $this->assertApiResponse($user->toArray());
    }

    /**
     * @test
     */
    public function test_update_user()
    {
        $user = User::factory()->create();
        $editedUser = User::factory()->make()->toArray();

        $this->response = $this->actingAs($user, 'api')->json(
            'PATCH',
            '/api/v1/user',
            $editedUser
        );

        $this->assertApiResponse($editedUser);
    }

    /**
     * @test
     */
    public function test_delete_user()
    {
        $user = User::factory()->create();

        $this->response = $this->actingAs($user, 'api')->json(
            'DELETE',
             '/api/v1/user'
         );

        $this->assertApiSuccess();
        $this->response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/v1/user'
        );

        $this->response->assertStatus(404);
    }
}
