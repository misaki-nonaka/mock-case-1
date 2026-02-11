<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;

class SellTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 出品した商品の情報が保存されている() {
        $me = User::factory()->create();

        $categories = Category::factory()->count(2)->sequence(
            ['content' => 'ファッション'],
            ['content' => '家電'],
        )->create();

        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg');

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get('/sell');
        $response->assertStatus(200);

        $response = $this->post("/sell", [
            'item_img' => $file,
            'category' => [$categories[0]->id, $categories[1]->id],
            'condition' => 1,
            'item_name' => 'サンプルA',
            'brand' => 'ブランドA',
            'detail' => '詳細説明A',
            'price' => 12000,
        ]);

        $files = Storage::disk('public')->files('items');

        $this->assertCount(1, $files);
        $this->assertStringEndsWith('_test.jpg', $files[0]);

        $this->assertDatabaseHas('items', [
            'item_name' => 'サンプルA',
            'brand' => 'ブランドA',
            'price' => 12000,
            'detail' => '詳細説明A',
            'condition' => 1,
            'user_id' => $me->id,
            'sold' => 0,
        ]);

        $item = Item::where('item_name', 'サンプルA')->first();

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $categories[0]->id
        ]);
        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $categories[1]->id
        ]);
        }
}
