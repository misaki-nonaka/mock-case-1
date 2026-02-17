<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <title>coachtechフリマ</title>
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo"><img src="/images/COACHTECHヘッダーロゴ.png" alt=""></a>
        </div>
        <div class="header-search">
            @hasSection('hideCommon')
            @else
                <form action="/" method="get">
                    <input type="search" class="header-search__inner" name="keyword" placeholder="なにをお探しですか？">
                </form>
            @endif
        </div>
        <div class="header-nav">
            @hasSection('hideCommon')
            @else
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
            @endif
        </div>
    </header>

    <main>
        <div class="content">
            @yield('content')
        </div>
    </main>
</body>
</html>