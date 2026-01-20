@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
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
    <div class="item-detail">
        <div class="item-image">
            <div class="item-image__inner">
                <img src="{{ asset($item->item_img) }}" alt="sample">
                @if($item->sold == 1)
                    <span class="sold-badge">Sold</span>
                @endif
            </div>
        </div>
        <div class="description-box">
            <div class="description-block">
                <h1 class="item-name">{{ $item->item_name }}</h1>
                <p class="item-brand">{{ $item->brand }}</p>
                <p class="item-price">&yen; <span>{{ number_format($item->price) }}</span>(税込)</p>
                <div class="item-list__count">
                    <div class="count__like">
                        @if($isLiked)
                            <form action="/item/unlike/{{ $item->id }}" method="get">
                            @csrf
                                <button type="submit" class="like-button">
                                    <img src="/images/ハートロゴ_ピンク.png" alt="">
                                </button>
                            </form>
                        @else
                            <form action="/item/like/{{ $item->id }}" method="get">
                            @csrf
                                <button type="submit" class="like-button">
                                    <img src="/images/ハートロゴ_デフォルト.png" alt="">
                                </button>
                            </form>
                        @endif
                        <p>{{ $item->likes_count }}</p>
                    </div>
                    <div class="count__comment">
                        <img src="/images/ふきだしロゴ.png" alt="">
                        <p>{{ $item->comments_count }}</p>
                    </div>
                </div>
            </div>
            <div class="purchase-btn">
                <form action="{{route('purchase', $item->id)}}" method="get">
                    <button type="submit">購入手続きへ</button>
                </form>
            </div>
            <div class="description-block">
                <h2 class="item-description__title">商品説明</h2>
                <p class="item-description__text">{{ $item->detail }}</p>
            </div>
            <div class="description-block">
                <h2 class="item-info__title">商品の情報</h2>
                <div class="item-info__inner">
                    <h3>カテゴリー</h3>
                    @foreach($item->categories as $category)
                        <div class="info-category">
                            {{ $category->content }}
                        </div>
                    @endforeach
                </div>
                <div class="item-info__inner">
                    <h3>商品の状態</h3>
                    <p>
                        @if($item->condition == 1)
                            良好
                        @elseif($item->condition == 2)
                            目立った傷や汚れなし
                        @elseif($item->condition == 3)
                            やや傷や汚れあり
                        @elseif($item->condition == 4)
                            状態が悪い
                        @endif
                    </p>
                </div>
            </div>
            <div class="description-block">
                <h2 class="item-list__comment-title">コメント({{ $item->comments_count }})</h2>
                @foreach($item->comments as $comment)
                    <div class="comment-user">
                        <img src="{{ asset($comment->user->profile->profile_img) }}" alt="画像">
                        <p>{{ $comment->user->profile->nickname}}</p>
                    </div>
                    <p class="item-list__comment">{{$comment->text}}</p>
                @endforeach
                <h3 class="comment-input">商品へのコメント</h3>
                <div class="comment-input__form">
                    <form action="/item/comment/{{$item->id}}" method="post">
                        @csrf
                        <textarea name="text"></textarea>
                        <button type="submit">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection