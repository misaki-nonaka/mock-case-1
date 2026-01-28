@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
                        @if($item->sold == 0)
                        <a href="/item/{{ $item->id }}" class="item-list__link">
                        @endif
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