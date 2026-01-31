<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Purchase;
use App\Models\Shipment;

class PurchaseController extends Controller
{
    public function purchase($item_id){
        $item = Item::with('shipment')->find($item_id);
        $profile = Profile::where('user_id', auth()->id())->first();
        $address = session('address') ?? $profile->only(['zipcode', 'address', 'building']);
        $payment = session('payment') ?? 'konbini';

        return view('purchase', compact('item', 'address', 'payment'));
    }

    public function payment(Request $request, $item_id){
        session(['payment' => $request->payment]);
        return redirect()->route('purchase', $item_id);
    }

    public function editAddress($item_id){
        return view('shipment', compact('item_id'));
    }

    public function updateAddress(AddressRequest $request, $item_id){
        session(['address' =>
        [
            'zipcode' => $request->zipcode,
            'address' => $request->address,
            'building' => $request->building
        ]]);
        return redirect()->route('purchase', $item_id);
    }

    public function complete($item_id){
        $user = auth()->user();
        $address = session('address')
        ?? $user->profile->only(['zipcode', 'address', 'building']);
        $payment = session('payment', 'konbini');

        Item::find($item_id)->update(['sold' => 1]);
        Purchase::create([
            'item_id' => $item_id,
            'user_id' => $user->id,
            'payment' => $payment
        ]);
        Shipment::create([
            'item_id' => $item_id,
            'item_zipcode' => $address['zipcode'],
            'item_address' => $address['address'],
            'item_building' => $address['building']
        ]);

        session()->forget(['address', 'payment']);

        return redirect('/');
    }
}
