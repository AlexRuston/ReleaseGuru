<?php

namespace Tests\Feature\Users;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    protected $testUser;

    public function setUp() : void {
        parent::setUp();

        // create user
        $this->testUser = User::find(1);
    }

    /*
     * successfully create a user
     * correct policy on the acting user
     * correct data posted
     * */
    public function test_user_can_be_created(): void
    {
        // get request to /users
        $response = $this->actingAs($this->testUser)
            ->post('/users', [
                'name' => 'Test User',
                'email' => 'test@test.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $response->assertStatus(302);
    }
}
