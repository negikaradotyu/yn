@extends('layouts.app2') 

@section('content2')

<main class="main-menus">
    <div class="menu-title4">
        <div class="menu-subject">
            <div class="myprofile">
            Mypage
            </div>
            </div>
            <div class="contents">
            @if($results->isEmpty())
    <p>検索結果はありませんでした。</p>
@else
    @foreach($results as $result)
        <p>{{$result->question}}</p>
    @endforeach
@endif

            </div>
            
           
        
</main>

@endsection

@section('content')
    
    
    <div class="categories">
        @foreach($categories as $category)
            <a href="category{{ $category['category'] }}">{{ $category['name'] }}</a>
        @endforeach

    </div>
    <form action="/search" method="GET">
  <textarea name="search" rows="1" cols="10"></textarea>
  <br>
  <input type="submit" value="検索">
</form>

@endsection