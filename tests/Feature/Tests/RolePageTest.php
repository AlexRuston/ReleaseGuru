<?php

namespace Tests\Feature\Tasks;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class RolePageTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function test_role_list_screen_can_be_rendered(): void
    {
        $response = $this->get('/roles');

        $response->assertStatus(200);
    }
}
