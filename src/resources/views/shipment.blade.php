@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shipment.css') }}">
@endsection

@section('search')
    <form action="/search" method="get">
        @csrf
        <input type="search" class="header-search__inner" name="keyword" placeholder="なにをお探しですか？">
    </form>
@endsection

@section('nav')
    <ul class="header-nav__inner">
        @if (Auth::check())
        <li class="header-nav__item">
            <form action="/logout" method="post" class="header-nav__form">
                @csrf
                <button class="header-nav__button">ログアウト</button>
            </form>
        </li>
        @else
        <li class="header-nav__item">
            <a href="/login" class="header-nav__link">ログイン</a>
        </li>
        @endif
        <li class="header-nav__item">
            <a href="/mypage" class="header-nav__link">マイページ</a>
        </li>
        <li class="header-nav__item--sell">
            <a href="/sell" class="header-nav__link--sell">出品</a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="shipment-box">
        <h1 class="shipment-title">住所の変更</h1>
        <form action="/purchase/address/{{ $item_id }}" method="post" class="shipment-form">
            @csrf
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