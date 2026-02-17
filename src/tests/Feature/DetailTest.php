<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Category;
use App\Models\Profile;
use App\Models\User;

class DetailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function すべての情報が表示される() {
        $item = Item::factory()->create([
            'item_name' => 'アイテムA',
            'brand' => 'ブランドA',
            'price' => 10000,
            'detail' => '詳細説明A',
            'condition' => 1,
        ]);

        $categories = Category::factory()->count(2)->sequence(
            ['content' => 'ファッション'],
            ['content' => '家電'],
        )->create();

        $item->categories()->attach(
            $categories->pluck('id')
        );

        $likes = Like::factory()->count(5)->create([
            'item_id' => $item->id,
        ]);

        $commentUser = User::factory()->create();

        $comments = Comment::factory()->count(3)->create([
            'item_id' => $item->id,
            'user_id' => $commentUser->id,
        ]);

        $profile = Profile::factory()->create([
            'user_id' => $commentUser->id,
        ]);

        $response = $this->get(route('detail', $item->id));
        $response->assertStatus(200);

        $response->assertSee('storage/items/Armani+Mens+Clock.jpg');
        $response->assertSee('アイテムA');
        $response->assertSee('ブランドA');
        $response->assertSee(number_format(10000));
        $response->assertViewHas('item', function($item){
            return $item->likes_count == 5;
        });
        $response->assertViewHas('item', function($item){
            return $item->comments_count == 3;
        });
        $response->assertSee('詳細説明A');
        $response->assertSee('ファッション');
        $response->assertSee('家電');
        $response->assertSee('良好');
        $response->assertSee($commentUser->nickname);
        foreach ($comments as $comment) {
            $response->assertSee($comment->text);
        }
    }

    /** @test */
    public function 複数カテゴリが表示される() {
        $item = Item::factory()->create();

        $categories = Category::factory()->count(5)->sequence(
            ['content' => 'ファッション'],
            ['content' => '家電'],
            ['content' => 'インテリア'],
            ['content' => 'レディース'],
            ['content' => 'メンズ'],
        )->create();

        $item->categories()->attach(
            $categories->random(2)->pluck('id')
        );

        $response = $this->get(route('detail', $item->id));
        $response->assertStatus(200);

        $response->assertViewHas('item', function($item){
            return $item->categories->count() == 2;
        });
        
        foreach ($item->categories as $category) {
            $response->assertSee($category->content);
        }
    }
}
