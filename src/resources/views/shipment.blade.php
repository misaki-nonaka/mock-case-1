@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shipment.css') }}">
@endsection

@section('content')
    <div class="shipment-box">
        <h1 class="shipment-title">住所の変更</h1>
        <form action="/purchase/address/{{ $item_id }}" method="post" class="shipment-form">
            @csrf
            @method('patch')
            <div class="shipment-form__group">
                <p class="shipment-form__title">郵便番号</p>
                <input type="text" name="zipcode" class="shipment-form__content" value="{{session('address[zipcode]')}}">
                <p class="shipment-form__error-message">
                    @error('zipcode')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="shipment-form__group">
                <p class="shipment-form__title">住所</p>
                <input type="text" name="address" class="shipment-form__content">
                <p class="shipment-form__error-message">
                    @error('address')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="shipment-form__group">
                <p class="shipment-form__title">建物名</p>
                <input type="text" name="building" class="shipment-form__content">
            </div>
            <button type="submit" class="shipment-form__button">更新する</button>
        </form>
    </div>
@endsection