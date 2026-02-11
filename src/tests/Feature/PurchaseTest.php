<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 購入ボタンを押下すると購入完了() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $me->id,
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get("/purchase". "/" .$item->id);
        $response->assertStatus(200);

        $response = $this->post("/checkout". "/" .$item->id);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'sold' => 1,
        ]);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'user_id' => $me->id,
            'status' => 'paid',
        ]);

        $response->assertRedirect('/');
    }

    /** @test */
    public function 購入した商品は商品一覧画面でsold表示() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $me->id,
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get("/purchase". "/" .$item->id);
        $response->assertStatus(200);

        $response = $this->post("/checkout". "/" .$item->id);

        $response = $this->get('/');
        $response->assertSee($item->item_name);
        $response->assertSee('Sold');
    }

    /** @test */
    public function プロフィール画面に購入した商品が追加() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $me->id,
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get("/purchase". "/" .$item->id);
        $response->assertStatus(200);

        $response = $this->post("/checkout". "/" .$item->id);

        $response = $this->get("/mypage/?page=buy");
        $response->assertSee($item->item_name);
    }
}
