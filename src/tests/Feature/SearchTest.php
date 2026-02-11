<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Like;
use App\Models\Item;
use App\Models\User;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品名部分一致検索() {
        $item = Item::factory()->count(2)->create([
            'item_name' => 'aaabbbccc'
        ]);

        $otherItem = Item::factory()->count(5)->create([
            'item_name' => 'others'
        ]);

        $response = $this->get('/?keyword=bbb');
        $response->assertStatus(200);

        $response->assertViewHas('items', function($items) {
            return $items->count() === 2;
        });

        $response->assertSee('aaabbbccc');
        $response->assertDontSee('others');
    }

    /** @test */
    public function マイリスト検索() {
        $me = User::factory()->create();
        $keyword = 'aaa';

        // 検索対象商品
        $itemNormal = Item::factory()->create([
            'item_name' => 'item-aaa-normal'
        ]);

        $itemLike = Item::factory()->create([
            'item_name' => 'item-aaa-like'
        ]);

        Like::factory()->create([
            'user_id' => $me->id,
            'item_id' => $itemLike->id,
        ]);

        // 検索対象外商品
        $otherItemNormal = Item::factory()->create([
            'item_name' => 'item-bbb-normal'
        ]);

        $otherItemLike = Item::factory()->create([
            'item_name' => 'item-bbb-like'
        ]);

        Like::factory()->create([
            'user_id' => $me->id,
            'item_id' => $otherItemLike->id,
        ]);

        $response = $this->get('/?keyword=' . $keyword);
        $response->assertStatus(200);

        $response->assertSee('item-aaa-normal');
        $response->assertSee('item-aaa-like');
        $response->assertDontSee('item-bbb-normal');
        $response->assertDontSee('item-bbb-like');
        
        $response->assertSee('/?tab=mylist&keyword=' . $keyword, false);

        $this->actingAs($me)->assertAuthenticated();
        $response = $this->get('/?tab=mylist&keyword=' . $keyword);
        $response->assertStatus(200);

        $response->assertSee('item-aaa-like');
        $response->assertDontSee('item-aaa-normal');
        $response->assertDontSee('item-bbb-normal');
        $response->assertDontSee('item-bbb-like');
    }
}
