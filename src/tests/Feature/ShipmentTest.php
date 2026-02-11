<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use App\Models\Shipment;

class ShipmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 住所を変更したら購入画面に反映() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $me->id,
            'zipcode' => '111-1111',
            'address' => '東京都中央区',
            'building' => 'サンプルマンション',
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get("/purchase". "/" .$item->id);
        $response->assertStatus(200);
        $response->assertSee('111-1111');
        $response->assertSee('東京都中央区');
        $response->assertSee('サンプルマンション');

        $response = $this->get("/purchase/address/" . $item->id);
        $response->assertStatus(200);

        $response = $this->patch("/purchase/address/" . $item->id, [
            'zipcode' => '222-2222',
            'address' => '北海道札幌市',
            'building' => 'テストハイツ',
        ]);

        $response->assertRedirect("/purchase". "/" .$item->id);

        $response = $this->get("/purchase". "/" .$item->id);
        $response->assertStatus(200);
        $response->assertSee('222-2222');
        $response->assertSee('北海道札幌市');
        $response->assertSee('テストハイツ');
    }

    /** @test */
    public function 購入商品に住所が紐づいて登録() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $me->id,
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get("/purchase/address/" . $item->id);
        $response->assertStatus(200);

        $response = $this->patch("/purchase/address/" . $item->id, [
            'zipcode' => '222-2222',
            'address' => '北海道札幌市',
            'building' => 'テストハイツ',
        ]);

        $response->assertRedirect("/purchase". "/" .$item->id);

        $response = $this->get("/purchase". "/" .$item->id);
        $response->assertStatus(200);
        $response->assertSee('222-2222');
        $response->assertSee('北海道札幌市');
        $response->assertSee('テストハイツ');

        $response = $this->post("/checkout". "/" .$item->id);

        $this->assertDatabaseHas('shipments', [
            'item_id' => $item->id,
            'item_zipcode' => '222-2222',
            'item_address' => '北海道札幌市',
            'item_building' => 'テストハイツ',
        ]);
    }
}
