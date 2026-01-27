@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
    <div class="profile-content">
        <h1 class="profile-title">プロフィール設定</h1>
        <form action="/mypage/profile" method="post" enctype='multipart/form-data'>
            @csrf
            @method('patch')
            <div class="profile-img__block">
                <div class="profile-img">
                    <img src="{{ asset(optional($profile)->profile_img ?? 'storage/profiles/noimage.jpg') }}" alt="">
                </div>
                <label class="profile-img__upload">画像を選択する
                    <input type="file" name="profile_img">
                </label>
                <p class="profile-form__error-message">
                    @error('profile_img')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="profile-input__block">
                <div class="profile-input__group">
                    <p class="profile-input__title">ユーザー名</p>
                    <input type="text" class="profile-input" name="nickname" value="{{ old('nickname', optional($profile)->nickname) }}">
                    <p class="profile-form__error-message">
                        @error('nickname')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="profile-input__group">
                    <p class="profile-input__title">郵便番号</p>
                    <input type="text" class="profile-input" name="zipcode" value="{{ old('zipcode', optional($profile)->zipcode) }}">
                    <p class="profile-form__error-message">
                        @error('zipcode')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="profile-input__group">
                    <p class="profile-input__title">住所</p>
                    <input type="text" class="profile-input" name="address" value="{{ old('address', optional($profile)->address) }}">
                    <p class="profile-form__error-message">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="profile-input__group">
                    <p class="profile-input__title">建物名</p>
                    <input type="text" class="profile-input" name="building" value="{{ old('building', optional($profile)->building) }}">
                    <p class="profile-form__error-message">
                    </p>
                </div>
            </div>
            <div class="profile-button">
                <button type="submit">更新する</button>
            </div>
        </form>
    </div>
@endsection