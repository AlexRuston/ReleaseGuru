<?php

namespace Tests\Feature\Projects;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ProjectPageTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function test_project_list_screen_can_be_rendered(): void
    {
        $response = $this->get('/projects');

        $response->assertStatus(200);
    }
}
