<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Shipment;

class StripeController extends Controller
{
    public function checkout(Request $request, $item_id)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $user = auth()->user();

        $payment = session('payment', 'konbini');
        $address = session('address')
        ?? $user->profile->only(['zipcode', 'address', 'building']);

        // コンビニ支払いの場合のみ、即時購入完了とする
        if($payment == 'konbini') {
            $purchase = Purchase::create([
                'item_id' => $item_id,
                'user_id' => $user->id,
                'payment' => $payment,
                'item_zipcode' => $address['zipcode'],
                'item_address' => $address['address'],
                'item_building' => $address['building'],
                'status' => 'paid',
            ]);

            Item::find($item_id)->update(['sold' => 1]);

            Shipment::firstOrCreate(
                ['item_id' => $item_id],
                [
                    'item_zipcode' => $purchase->item_zipcode,
                    'item_address' => $purchase->item_address,
                    'item_building' => $purchase->item_building,
                ]
            );

            return redirect()->route('index');
        }

        else {
            $purchase = Purchase::create([
                'item_id' => $item_id,
                'user_id' => $user->id,
                'payment' => $payment,
                'item_zipcode' => $address['zipcode'],
                'item_address' => $address['address'],
                'item_building' => $address['building'],
                'status' => 'pending',
            ]);

            session()->forget(['address', 'payment']);

            $item = Item::find($item_id);

            $session = Session::create([
                'payment_method_types' => [$payment],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->item_name,
                            'description' => $item->detail,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',

                'metadata' => [
                    'purchase_id' => $purchase->id,
                ],

                'success_url' => route('index'),
                'cancel_url' => route('detail', $item->id),
            ]);

            return redirect($session->url);
        }
    }

    public function handle(Request $request)
    {
        $event = json_decode($request->getContent());

        if (
            $event->type === 'checkout.session.completed' ||
            $event->type === 'checkout.session.async_payment_succeeded'
            )
        {
            $session = $event->data->object;

            $purchaseId = $session->metadata->purchase_id;

            $purchase = Purchase::find($purchaseId);
            $purchase->update(['status' => 'paid']);

            Item::find($purchase->item_id)->update(['sold' => 1]);

            Shipment::firstOrCreate(
                ['item_id' => $purchase->item_id],
                [
                    'item_zipcode' => $purchase->item_zipcode,
                    'item_address' => $purchase->item_address,
                    'item_building' => $purchase->item_building,
                ]
            );
        }

        return response()->json(['status' => 'success']);
    }

}
