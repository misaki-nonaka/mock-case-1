<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use App\Models\Purchase;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function プロフィールページに必要な情報が取得できる() {
        $me = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $me->id,
            'nickname' => 'サンプル花子',
            'profile_img' => 'storage/profiles/sample01.jpg',
        ]);

        $sellItem = Item::factory()->create([
            'user_id' => $me->id,
            'item_name' => '出品した商品',
        ]);

        $buyItem = Item::factory()->create([
            'item_name' => '購入した商品',
        ]);

        Purchase::factory()->create([
            'item_id' => $buyItem->id,
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get('/mypage');
        $response->assertStatus(200);

        $response->assertSee('storage/profiles/sample01.jpg');
        $response->assertSee('サンプル花子');
        $response->assertSee('出品した商品');

        $response = $this->get('/mypage/?page=buy');
        $response->assertStatus(200);
        $response->assertSee('storage/profiles/sample01.jpg');
        $response->assertSee('サンプル花子');
        $response->assertSee('購入した商品');
    }
}
