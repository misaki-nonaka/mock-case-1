<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログイン済みユーザーはコメント送信可() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $me->id,
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get(route('detail', $item->id));
        $response->assertStatus(200);

        $response->assertViewHas('item', function($item){
            return $item->comments_count == 0;
        });

        $response = $this->post("/item/comment/" . $item->id, [
            'text' => 'コメントテスト',
        ]);

        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $me->id,
            'text' => 'コメントテスト',
        ]);

        $response = $this->get(route('detail', $item->id));
        $response->assertStatus(200);

        $response->assertViewHas('item', function($item){
            return $item->comments_count == 1;
        });
        $response->assertSee('コメントテスト');
    }

    /** @test */
    public function ログイン前ユーザーはコメント送信不可() {
        $item = Item::factory()->create();

        $response = $this->get(route('detail', $item->id));
        $response->assertStatus(200);

        $response->assertViewHas('item', function($item){
            return $item->comments_count == 0;
        });

        $response = $this->post("/item/comment/" . $item->id, [
            'text' => 'コメントテスト',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'text' => 'コメントテスト',
        ]);
    }

    /** @test */
    public function コメント未入力のバリデーション() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $me->id,
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get(route('detail', $item->id));
        $response->assertStatus(200);

        $response = $this->post("/item/comment/" . $item->id, [
            'text' => '',
        ]);

        $response->assertSessionHasErrors(['text' => 'コメントを入力してください']);
    }

    /** @test */
    public function コメント255文字以上のバリデーション() {
        $item = Item::factory()->create();

        $me = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $me->id,
        ]);

        $this->actingAs($me)->assertAuthenticated();

        $response = $this->get(route('detail', $item->id));
        $response->assertStatus(200);

        $response = $this->post("/item/comment/" . $item->id, [
            'text' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors(['text' => 'コメントは255文字以内で入力してください']);
    }
}
