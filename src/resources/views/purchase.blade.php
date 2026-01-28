@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <div class="content-box">
        <div class="purchase-info">
            <div class="item-block">
                <div class="item-img">
                    <img src="{{ asset($item->item_img) }}" alt="">
                </div>
                <div class="item-info">
                    <h2 class="item-name">{{ $item->item_name }}</h2>
                    <p class="item-price"><span>&yen;</span> {{ number_format($item->price) }}</p>
                </div>
            </div>
            <div class="payment-block">
                <h3 class="payment-title">支払い方法</h3>
                <form action="/payment/{{ $item->id }}" method="post" class="payment__select">
                    @csrf
                    <select name="payment" onchange="this.form.submit()">
                        <option value="" hidden>選択してください</option>
                        <option value="1">コンビニ支払い</option>
                        <option value="2">カード支払い</option>
                    </select>
                </form>
            </div>
            <div class="shipment-block">
                <div class="shipment-title">
                    <h3>配送先</h3>
                    <a href="/purchase/address/{{ $item->id }}">変更する</a>
                </div>
                <div class="shipment-inner">
                    <p>&#12306;{{ $address['zipcode'] }}</p>
                    <p>{{ $address['address'] }}</p>
                    <p>{{ $address['building'] }}</p>
                </div>
            </div>
        </div>
        <div class="purchase-summary">
            <table class="summary-table">
                <tr>
                    <th>商品代金</th>
                    <td>&yen; <span>{{ number_format($item->price) }}</span></td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td>
                        @if($payment == 1)
                            コンビニ払い
                        @else
                            カード払い
                        @endif
                    </td>
                </tr>
            </table>
            <form action="/complete/{{ $item->id }}" method="post" class="summary-form">
                @csrf
                <button type="submit">購入する</button>
            </form>
        </div>
    </div>
@endsection