<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;

class ItemController extends Controller
{
    public function index(Request $request){
        $activeTab = $request->query('tab', 'home');
        $keyword = $request->query('keyword');
        $userId = Auth::id();
        $itemsQuery = Item::query()
            ->when($userId, fn ($q) => 
                $q->where('user_id', '!=', $userId));
        if($keyword){
            $itemsQuery->where('item_name', 'LIKE',"%{$keyword}%");
        }
        $items = $itemsQuery->get();

        $myListsQuery = Like::with('favorites')->where('user_id', $userId);
        if ($keyword) {
            $myListsQuery->whereHas('favorites', function ($q) use ($keyword) {
                $q->where('item_name', 'like', "%{$keyword}%");
            });
        }
        $myLists = $myListsQuery->get();

        return view('index', compact('activeTab', 'items', 'myLists'));
    }

    public function detail($item_id){
        $item = Item::with([
            'categories',
            'comments.user.profile',
        ])
        ->withCount([
            'comments',
            'likes',
        ])
        ->findOrFail($item_id);

        $isLiked = $item->likes()
        ->where('user_id', auth()->id())
        ->exists();

        $mySellItem = $item->user_id == auth()->id() ? "true" : "false";

        return view('detail', compact('item', 'isLiked', 'mySellItem'));
    }

    public function like($item_id){
        Like::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id
        ]);

        return redirect()->route('detail', $item_id);
    }

    public function unlike($item_id){
        Like::where('user_id', auth()->id())->where('item_id', $item_id)->delete();

        return redirect()->route('detail', $item_id);
    }

    public function comment(CommentRequest $request, $item_id){
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
            'text' => $request->text
        ]);
        return redirect()->route('detail', $item_id);
    }
}
