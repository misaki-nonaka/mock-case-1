@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
    <div class="tab-list">
        <ul class="tab-list__inner">
            <li class="tab-list__item">
                <a href="/" class="tab-list__link {{ $activeTab === 'home' ? 'active' : '' }}">おすすめ</a>
            </li>
            <li class="tab-list__item">
                <a href="/?tab=mylist" class="tab-list__link {{ $activeTab === 'mylist' ? 'active' : '' }}">マイリスト</a>
            </li>
        </ul>
    </div>

    <div class="item-list">
        @if($activeTab === 'home')
            @foreach($items as $item)
                <div class="item-list__inner">
                    <div class="item-list__image">
                        <a href="/item/{{ $item->id }}" class="item-list__link">
                            <img src="{{ asset($item->item_img) }}" alt="">
                            @if($item->sold == 1)
                                <span class="sold-badge">Sold</span>
                            @endif
                        </a>
                    </div>
                    <p>{{ $item->item_name }}</p>
                </div>
            @endforeach
        @elseif($activeTab === 'mylist')
            @foreach($myLists as $list)
                <div class="item-list__inner">
                    <div class="item-list__image">
                        <a href="/item/{{ $list->favorites->id }}" class="item-list__link">
                            <img src="{{ asset($list->favorites->item_img) }}" alt="">
                            @if($list->favorites->sold == 1)
                                <span class="sold-badge">Sold</span>
                            @endif
                        </a>
                    </div>
                    <p class="item-list__name">{{ $list->favorites->item_name }}</p>
                </div>
            @endforeach
        @endif
    </div>

@endsection