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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <script rel="stylesheet" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ '/css/reset.css' }}">
    <link rel="stylesheet" href="{{ '/css/category.css' }}">
    <link rel="stylesheet" href="{{ '/css/new.css' }}">
    <link rel="stylesheet" href="{{ '/css/post.css' }}">
    <link rel="stylesheet" href="{{ '/css/mypage.css' }}">
    <link rel="stylesheet" href="{{ '/css/app.welcome2.css' }}">
    <link rel="stylesheet" href="{{ '/css/side-menu.css' }}">
    <link rel="stylesheet" href="{{ '/css/media.css' }}">
    
    @yield('css')
    </head>
<body class="antialiased">
<div class="top-wrapper">
    <div class="accesscount">
        <p>投票者数:{{ $counter }}</p>
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

                        <li><a href="/keijiban">
                            掲示板
                        </a>  </li>


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
                        <a href="/keijiban">
                            掲示板
                        </a>  
                    </li>              
                    </li>
                



                @endguest

    </ul>

</div>
@guest <div class="attention">あなたはGUEST、
投稿/投票履歴は記録されません</div>
@endguest
<div class="menus">
    <div class="side-menu">
        <div class="categories">
            <div class="subtitle">
                <p><i class="fa-regular fa-folder"></i>Categories</p>
            </div>
        </div>
        <div class="content">
            @yield('content5')
        </div>
    </div>
    <div class="main-menu">
        <div class="post">
            <div class="subtitle">
                <p><i class="fa-regular fa-folder"></i>議題投稿</p>
            </div>
            <div class="content">
                @yield('content2')
            </div>
        </div>
        <div class="new">
            <div class="subtitle">
                <p><i class="fa-regular fa-folder"></i>What's New!!</p>
            </div>            
            <div class="content">
                @yield('content3')
            </div>
        </div>
    </div>
</div>


</body>
</html>
