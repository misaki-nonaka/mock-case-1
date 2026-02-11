<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Like;
use App\Models\Item;
use App\Models\User;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいね商品登録() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get(route('detail', $item->id));
        $response->assertStatus(200);

        $response->assertViewHas('item', function($item){
            return $item->likes_count == 0;
        });

        $response = $this->get("/item/like/" . $item->id);

        $this->assertDatabaseHas('likes', [
            'user_id' => $me->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get(route('detail', $item->id));

        $response->assertViewHas('item', function($item){
            return $item->likes_count == 1;
        });
    }

    /** @test */
    public function いいね済みは色付きアイコン() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $this->actingAs($me)->assertAuthenticated();

        $likes = Like::factory()->create([
            'user_id' => $me->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get(route('detail', $item->id));
        $response->assertStatus(200);

        $response->assertSee("/images/ハートロゴ_ピンク.png");
    }

    /** @test */
    public function いいねを解除できる() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $this->actingAs($me)->assertAuthenticated();

        $likes = Like::factory()->create([
            'user_id' => $me->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get(route('detail', $item->id));
        $response->assertStatus(200);

        $response->assertViewHas('item', function($item){
            return $item->likes_count == 1;
        });

        $response = $this->get("/item/unlike/" . $item->id);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $me->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get(route('detail', $item->id));

        $response->assertViewHas('item', function($item){
            return $item->likes_count == 0;
        });
        
    }
}
