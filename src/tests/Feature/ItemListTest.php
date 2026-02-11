<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 全商品が表示されていること() {
        Item::factory()->count(3)->create();

        $response = $this->get(route('index'));
        $response->assertStatus(200);

        $response->assertViewHas('items', function($items) {
            return $items->count() === 3;
        });
    }

    /** @test */
    public function 購入済みにsoldがついているか() {
        Item::factory()->create([
            'sold' => 1,
        ]);

        $response = $this->get(route('index'));
        $response->assertStatus(200);

        $response->assertSee('Sold');
    }

    /** @test */
    public function 自分が出品した商品非表示() {
        $me = User::factory()->create();

        $myItem = Item::factory()->create([
            'user_id' => $me->id,
            'item_name' => '自分の商品',
        ]);

        $otherItem = Item::factory()->create([
            'item_name' => '他人の商品'
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get(route('index'));

        $response->assertDontSee('自分の商品');

        $response->assertSee('他人の商品');        
    }
}
