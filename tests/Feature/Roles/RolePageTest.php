<?php

namespace Tests\Feature\Roles;

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
