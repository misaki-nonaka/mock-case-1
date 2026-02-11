<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 支払い方法選択() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $me->id,
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get("/purchase". "/" .$item->id);
        $response->assertStatus(200);
        $response->assertSee('コンビニ払い');

        $response = $this->post("/payment". "/" .$item->id, [
            'payment' => 'card',
        ]);

        $response->assertRedirect("/purchase". "/" .$item->id);

        $response = $this->get("/purchase". "/" .$item->id);

        $response->assertSee('カード払い');

        $response = $this->post("/payment". "/" .$item->id, [
            'payment' => 'konbini',
        ]);

        $response->assertRedirect("/purchase". "/" .$item->id);

        $response = $this->get("/purchase". "/" .$item->id);

        $response->assertSee('コンビニ払い');
    }
}
