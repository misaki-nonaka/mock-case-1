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
            @yield('search')
        </div>
        <div class="header-nav">
            @yield('nav')
        </div>
    </header>

    <main>
        <div class="content">
            @yield('content')
        </div>
    </main>
</body>
</html>