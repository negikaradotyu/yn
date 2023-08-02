<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Yes or No</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script rel="stylesheet" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ '/css/app.css' }}" rel="stylesheet">
    <link href="{{ '/css/app.css' }}" rel="stylesheet">
    <link href="{{ '/css/app.welcome2.css' }}" rel="stylesheet">
    

    @yield('css')
    </head>
    <body class="antialiased">



<div class="top-wrapper">
    <div class="accesscount">
        <p>投票者数:{{ $counter }}</p>
    </div>
    <a class="site-title" href="{{ url('/home') }}">
        <div class="blinking-text text-center">
            <span class="yes">
            <!-- <span class="overlay">YESorNO</span> -->
            はい/いいえ
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
                    <li>
                        
                </li>
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
                    </li>
                @endguest
    </ul>
</div>

       





    </body>
</html>
