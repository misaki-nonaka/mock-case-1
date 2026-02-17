@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
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
                    <button type="submit" {{$item->sold==1 ? "disabled" : ""}}>購入手続きへ</button>
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
                    <div class="info-category__box">
                    @foreach($item->categories as $category)
                        <div class="info-category">
                            {{ $category->content }}
                        </div>
                    @endforeach
                    </div>
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
                        <img src="{{ asset(optional($comment)->user->profile->profile_img ?? 'storage/profiles/noimage.jpg') }}" alt="">
                        <p>{{ $comment->user->profile->nickname}}</p>
                    </div>
                    <p class="item-list__comment">{{$comment->text}}</p>
                @endforeach
                <h3 class="comment-input">商品へのコメント</h3>
                <div class="comment-input__form">
                    <form action="/item/comment/{{$item->id}}" method="post">
                        @csrf
                        <textarea name="text"></textarea>
                        <p class="comment-form__error-message">
                            @error('text')
                                {{ $message }}
                            @enderror
                        </p>
                        <button type="submit">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection