<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>らーめん部</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-light mb-2 navbar-expand-sm" style="background-color: #111">
            <img class="brand-logo" src="{{ asset('storage/materials/ramen2.png') }}" alt="ラーメンのシルエット">
            <a class="navbar-brand" href="{{ route('home') }}">らーめん部</a>
            <ul>
                <li><a class="nav-item nav-link" href="{{ route('home') }}">ホーム</a></li>
                @if(Auth::check())
                <li><a class="nav-item nav-link" href="{{ route('posts.myposts', ['user_id' => Auth::id()]) }}">マイページ</a></li>
                <li><a class="nav-item nav-link" href="{{ route('toSettingPage') }}">設定</a></li>
                <li>
                    <a class="nav-item nav-link" href="{{ route('logout') }}" 
                    onclick="event.preventDefault();
                            document.getElementById('logout-form').submit()";>ログアウト</a>
                </li>
                    <form action="{{ route('logout') }}" method="post" id="logout-form">
                        @csrf
                    </form>
                @else
                <li><a class="nav-item nav-link" href="{{ route('login') }}">ログイン</a></li>
                <li><a class="nav-item nav-link" href="{{ route('register') }}">会員登録</a></li>
                @endif
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
    
</body>
</html>