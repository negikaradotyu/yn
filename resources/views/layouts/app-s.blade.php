<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('YESorNO', 'YESorNO') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    
    <script src="{{ mix('js/app.js') }}"></script>
    <!-- Styles -->
    <link href="{{ '/css/app-top.css' }}" rel="stylesheet">
    <link href="{{ '/css/app.css' }}" rel="stylesheet">
    @yield('css')
</head>
<body>
    <div class="top-wrapper">
        <div class="accesscount">
            <p>{{ $counter }} Voters</p>
        </div>
    
        <a class="site-title" href="{{ url('/home') }}">
            <div class="blinking-text text-center">
                <span class="yes">
                <span class="overlay">YESorNO</span>
                はい
                </span>
                <span class="no">
                <span class="overlay">YESorNO</span>
                いいえ
                </span>
                <p class="sub">投票 ～Let's Vote～</p>
            </div>
        </a>
    
        <ul class="member-menu">
            @guest
                <li>
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li>
                        <a  href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="member-menu">
                    <a href="/mypage/{{$user['id']}}">
                        My page {{ Auth::user()->name }} 
                    </a>
                    <div class="logout-action">
                        <a  href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    <div class="keijiban">
                        <a href="/keijiban">掲示板へ</a>
                    </div>
                </li>
            @endguest
        </ul>
    </div>

    <main>
        <div class="main-menu">
            <div class="menu-title1">
                <div class="menu-subject">
                   All categories
                </div>
                @yield('content')
            </div>
            <div class="menu-title2">
                <div class="menu-subject">
                    質問投稿
                </div>
                @yield('content2')
            </div>
            <div class="menu-title3">
                @yield('content3')
            </div>
        </div> 
    </main>
</body>
</html>
