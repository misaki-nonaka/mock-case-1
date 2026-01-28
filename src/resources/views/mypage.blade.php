@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="profile-block">
        <div class="profile-img">
            <img src="{{ asset(optional($contents)->profile->profile_img ?? 'storage/profiles/noimage.jpg') }}" alt="">
        </div>
        <h1 class="profile-name">
            {{ $contents?->profile?->nickname }}
        </h1>
        <a href="/mypage/profile" class="profile-button">プロフィールを編集</a>
    </div>
    <div class="tab-list">
        <ul class="tab-list__inner">
            <li class="tab-list__item">
                <a href="/mypage/?page=sell" class="tab-list__link {{ $activePage === 'sell' ? 'active' : '' }}">出品した商品</a>
            </li>
            <li class="tab-list__item">
                <a href="/mypage/?page=buy" class="tab-list__link {{ $activePage === 'buy' ? 'active' : '' }}">購入した商品</a>
            </li>
        </ul>
    </div>
    <div class="item-list">
        @if($activePage === 'sell')
            @foreach($contents->exhibits as $item)
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
        @elseif($activePage === 'buy')
            @foreach($contents->purchases as $item)
                <div class="item-list__inner">
                    <div class="item-list__image">
                        <a href="/item/{{ $item->buyItem->id }}" class="item-list__link">
                            <img src="{{ asset($item->buyItem->item_img) }}" alt="">
                            @if($item->buyItem->sold == 1)
                                <span class="sold-badge">Sold</span>
                            @endif
                        </a>
                    </div>
                    <p class="item-list__name">{{ $item->buyItem->item_name }}</p>
                </div>
            @endforeach
        @endif
    </div>
@endsection