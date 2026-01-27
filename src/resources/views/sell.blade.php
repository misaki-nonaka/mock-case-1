@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
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
    <div class="sell-content">
        <form action="/sell" method="post" enctype='multipart/form-data'>
            @csrf
            <h1 class="sell-title">商品の出品</h1>
            <div class="item-img__block">
                <p class="item-img__title">商品画像</p>
                <div class="item-img">
                    <label class="item-img__upload">画像を選択する
                        <input type="file" name="item_img">
                    </label>
                </div>
                <p class="sell-form__error-message">
                    @error('item_img')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="sell-content__inner">
                <h2 class="sell-content__title">商品の詳細</h2>
                <h3 class="sell-content__sub-title">カテゴリー</h3>
                <div class="sell-content__category">
                    @foreach($categories as $category)
                    <label class="category-label">{{ $category->content }}
                        <input type="checkbox" name="category[]" value="{{$category->id}}">
                    </label>
                    @endforeach
                </div>
                <p class="sell-form__error-message">
                    @error('category')
                        {{ $message }}
                    @enderror
                </p>
                <div class="sell-input__group">
                    <h3 class="sell-content__sub-title">
                        商品の状態
                    </h3>
                    <div class="sell-input__condition">
                        <select name="condition" class="sell-input__select">
                            <option value="" hidden>選択してください</option>
                            <option value="1">良好</option>
                            <option value="2">目立った傷や汚れなし</option>
                            <option value="3">やや傷や汚れあり</option>
                            <option value="4">状態が悪い</option>
                        </select>
                    </div>
                    <p class="sell-form__error-message">
                        @error('condition')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <h2 class="sell-content__title">商品名と説明</h2>
                <div class="sell-input__group">
                    <h3 class="sell-content__sub-title">
                        商品名
                    </h3>
                    <input type="text" name="item_name">
                    <p class="sell-form__error-message">
                        @error('item_name')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="sell-input__group">
                    <h3 class="sell-content__sub-title">
                        ブランド名
                    </h3>
                    <input type="text" name="brand">
                    <p class="sell-form__error-message">
                    </p>
                </div>
                <div class="sell-input__group">
                    <h3 class="sell-content__sub-title">
                        商品の説明
                    </h3>
                    <textarea name="detail" cols="30" rows="10"></textarea>
                    <p class="sell-form__error-message">
                        @error('detail')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="sell-input__group">
                    <h3 class="sell-content__sub-title">
                        販売価格
                    </h3>
                    <div class="sell-input__price">
                        <input type="text" name="price">
                    </div>
                    <p class="sell-form__error-message">
                        @error('price')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
            <div class="sell-button">
                <button type="submit">出品する</button>
            </div>
        </form>
    </div>

@endsection