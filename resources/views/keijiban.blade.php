@extends('layouts.app2')

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

@section('content2')

    <div class="info">
        <p>みなさんへのお知らせ</p>
        <p>何か知らせることがあったらここに書きます。</p>
    </div>
    
    <p>自由に投稿</p>
    <div>
        <form method='POST' action="/toko" name="toko">
                @csrf
            <input type='hidden' name='user_id' value="{{ $user['id'] }}">
            <input type='hidden' name='user_name' value="{{ $user['name'] }}">
            <textarea class="form-control"  name="toko" rows="1" placeholder="自由にどうぞ"></textarea>    
            <input class="btn btn-primary" type="submit" value="Submit">
        </form>
    </div>
        @if(session('success'))
            <div class="alert alert-success" role="alert">
              {{ session('success') }}
            </div>
        @endif
        
    <div class="ichiran">
        @foreach($comments as $comment)
        <p>{{$comment['user_name']}}{{$comment['comment']}}</p>
        @endforeach
    </div>

@endsection
