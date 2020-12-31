<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\User;

class UserApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_read_user()
    {
        $user = User::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/users/'.$user->name
        );

        $this->assertApiResponse($user->toArray());
    }
}
