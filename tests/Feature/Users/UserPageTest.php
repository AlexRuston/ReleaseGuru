<?php

namespace Tests\Feature\Users;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserPageTest extends TestCase
{
    use RefreshDatabase;

    protected $testUser;
    protected $testUserToken;

    public function setUp() : void {
        parent::setUp();

        // create user
        $this->testUser = User::find(1);
    }

    /*
     * render the list users page
     * acting as a user who should have Policy access
     * */
    public function test_user_policy_allows_access(): void
    {
        // get request to /users
        $response = $this->actingAs($this->testUser)
            ->get('/users');

        // should see 200
        $response->assertStatus(200);
    }

    /*
     * attempt to render the list users page
     * acting as a user who should not have Policy access
     * should see a 403
     * */
    public function test_user_policy_blocks_access(): void
    {
        /*
         * get a standard access user
         * */
        $standardUser = User::find(2);
        // get request to /users
        $response = $this->actingAs($standardUser)
            ->get('/users');

        // should see 200
        $response->assertStatus(403);
    }
}
