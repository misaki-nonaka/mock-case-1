<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function プロフィールの初期値が表示されている() {
        $me = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $me->id,
            'nickname' => 'サンプル花子',
            'profile_img' => 'storage/profiles/sample01.jpg',
            'zipcode' => '111-1111',
            'address' => '東京都中央区',
            'building' => 'サンプルマンション',
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);

        $response->assertSee('storage/profiles/sample01.jpg');
        $response->assertSee('サンプル花子');
        $response->assertSee('111-1111');
        $response->assertSee('東京都中央区');
        $response->assertSee('サンプルマンション');
        }
}
