<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログアウト正常() {
    $user = User::factory()->create();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $response = $this->post('/logout');

    $this->assertGuest();

    $response->assertRedirect('/');
}
}
