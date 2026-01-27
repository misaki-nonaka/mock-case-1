<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Item;

class SellController extends Controller
{
    public function sell(){
        $categories = Category::all();
        return view('sell', compact('categories'));
    }

    public function exhibit(ExhibitionRequest $request){
        $user_id = auth()->id();
        $originalName = $request->file('item_img')->getClientOriginalName();
        $extension = $request->file('item_img')->getClientOriginalExtension();
        $fileName = time().'_' .$originalName;
        $target_path = 'public/items';
        $request->file('item_img')->storeAs($target_path, $fileName);

        $img_path = 'storage/items/';


        Item::create([
            'item_img' => $img_path.$fileName,
            'item_name' => $request->item_name,
            'brand' => $request->brand,
            'price' => $request->price,
            'detail' => $request->detail,
            'condition' => $request->condition,
            'user_id' => $user_id,
            'sold' => 0
        ])
        ->categories()->sync($request->category);


        return redirect('/');
    }
}
