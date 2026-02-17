<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Like;
use App\Models\Item;
use App\Models\User;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいね商品のみ表示() {
        $me = User::factory()->create();

        $favoriteItem = Item::factory()->create([
            'item_name' => 'いいねした商品'
        ]);
        $favorite = Like::factory()->create([
            'user_id' => $me->id,
            'item_id' => $favoriteItem->id,
        ]);
        $otherItem = Item::factory(10)->create([
            'item_name' => 'その他の商品'
        ]);

        $this->actingAs($me)->assertAuthenticated();
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        $response->assertViewHas('myLists', function($myLists) {
            return $myLists->count() === 1;
        });

        $response->assertSee('いいねした商品');
        $response->assertDontSee('その他の商品');
    }

    /** @test */
    public function 購入済みにsoldがついているか() {
        $me = User::factory()->create();

        $favoriteItem = Item::factory()->create([
            'sold' => 1,
        ]);
        $favorite = Like::factory()->create([
            'user_id' => $me->id,
            'item_id' => $favoriteItem->id,
        ]);
        
        $this->actingAs($me)->assertAuthenticated();
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        $response->assertSee('Sold');
    }

    /** @test */
    public function 未認証では表示されない() {
        $favoriteItem = Like::factory(3)->create(); 
        $otherItem = Item::factory(5)->create();

        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        $response->assertViewHas('myLists', function($myLists) {
            return $myLists->count() === 0;
        });

    }
}
