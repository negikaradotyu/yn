<!DOCTYPE html>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Styles -->
    
    <script src="{{ mix('js/app.js') }}"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ '/css/reset.css' }}">
    <link rel="stylesheet" href="{{ '/css/new.css' }}">
    <link rel="stylesheet" href="{{ '/css/post.css' }}">
    <link rel="stylesheet" href="{{ '/css/app.welcome2.css' }}">
    <link rel="stylesheet" href="{{ '/css/side-menu.css' }}">
    <link rel="stylesheet" href="{{ '/css/media.css' }}">
    @yield('css')
</head>
<body>
    <div class="main">
        <div class="top-wrapper">
            <div class="accesscount">
            <p><i class="fa-solid fa-check-to-slot"></i> :{{ $counter }}</p>
            </div>
            <a class="site-title" href="{{ url('/home') }}">
                <div class="blinking-text text-center">
                
                <span class="overlay">YESorNO</span>
                </div>
                <span class="yes">
                はい/いいえ
                </span>
                <p class="sub">投票 ～Let's Vote～</p>
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
                    <li>
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
                    </li>
                @endguest
            </ul>
        </div>
        <div class="menus">
            <div class="side-menu">
                <div class="categories">
                    <div class="subtitle"><p>All categories</p></div>
                   
                </div>
                <div class="content">
                    @yield('content')
                </div>
            </div>
            <div class="main-menu">
                <div class="post">
                    <div class="subtitle"><p>議題投稿</p></div>
                    
                    <div class="content">
                        @yield('content2')
                    </div>
                </div>
                <div class="new">
                    <div class="subtitle"><p>What's New!!</p></div>
                    
                    <div class="content">
                        @yield('content3')
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>