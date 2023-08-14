@extends('layouts.app2')

@section('content') 
<div class="categories">
    @foreach($categories as $category)
    <a href="{{ route('category', ['category' => $category['choose'], 'user' => $user]) }}"><i class="fa-regular fa-clipboard"></i>{{ $category['name'] }}</a>
@endforeach
    <a href="/mikaito"><i class="fa-solid fa-clipboard"></i>未回答</a>
    <a href="/topten"><i class="fa-solid fa-clipboard"></i>Top10</a>
    <a href="/home"><i class="fa-solid fa-house-crack"></i>Go to Home</a>
    <form action="/search" method="GET" class="search-form">
        <textarea name="search" rows="1" cols="10"></textarea>
        <input type="submit" value="検索">
    </form>
</div>

@endsection

@section('category')
<div class="keijiban">
    <div class="info">
        <div class="title">みなさんへのお知らせ</div>
        <div class="notice">
            <p>何か知らせることがあったらここに書きます。</p>
            <p>8/14:Youtubeチャンネルに作業動画をアップしました。</p>
            <p>https://www.youtube.com/watch?v=fa7VF8v0L-M</p>
            <p>Twitter開設：@Tsurugenefu</p>
        </div>        
    </div>
    <div class="ban">
        <div class="title">Comments
            @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        </div>
        <div class="commentform">
            <form method='POST' action="/toko" name="toko">
                    @csrf
                <input type='hidden' name='user_id' value="{{ $user['id'] }}">
                <input type='hidden' name='user_name' value="{{ $user['name'] }}">
                <textarea class="form-control"  name="toko" rows="1" placeholder="自由にどうぞ（上限50文字)" maxlength="50"></textarea>    
                <input class="btn btn-primary" type="submit" value="投稿">
            </form>
        </div>
        <div class="ichiran">
            <table class="commentban">
                <tr>
                    <th class="column1">Name</th>
                    <th class="column2">Comment</th>
                    <th class="column3">Date</th>
                </tr>
                
                @foreach($comments as $comment)
                <tr>
                    <td class="centerize">{{$comment['user_name']}}</td>
                    <td>{{$comment['comment']}}</td>
                    <td class="centerize">{{$comment['created_at']->format('Y-m-d')}}</td> 
                </tr>
                @endforeach
                
            </table>
        </div>
    </div>
</div>
@endsection
