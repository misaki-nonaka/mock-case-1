<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Item;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
        $target_path = 'items/';

        $file = $request->file('item_img');
        $image = Image::make($file)->resize(800, null, function($constraint) {
            $constraint->aspectRatio();
        })
        ->encode($extension, 75);

        Storage::disk('public')->put($target_path.$fileName, $image);

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
