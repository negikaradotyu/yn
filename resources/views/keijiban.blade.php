@extends('layouts.app2')

@section('content') 
    
    
<div class="categories">
        @foreach($categories as $category)
            <a href="category{{ $category['category'] }}"><i class="fa-regular fa-clipboard"></i>{{ $category['name'] }}</a>
        @endforeach

    </div>
    <form action="/search" method="GET">
  <textarea class="from-control" name="search" rows="1" cols="10"></textarea>
  <br>
  <input type="submit" value="検索">
</form>

@endsection

@section('category')
<div class="keijiban">
    <div class="info">
        <div class="title">みなさんへのお知らせ</div>
        <div class="notice">
            <p>何か知らせることがあったらここに書きます。</p>
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
                <textarea class="form-control"  name="toko" rows="1" placeholder="自由にどうぞ"></textarea>    
                <input class="btn btn-primary" type="submit" value="投稿">
            </form>
        </div>
        <div class="ichiran">
            <table>
                <tr>
                <th class="column1" >ID</th>
                <th class="column2">Comment</th>
                <th class="column3">Date</th>
                </tr>
                
                @foreach($comments as $comment)
                <tr>
                    <td>{{$comment['user_name']}}</td>
                    <td>{{$comment['comment']}}</td>
                    <td>{{$comment['created_at']}}</td> 
                </tr>
                @endforeach
                
            </table>
        </div>
    </div>
</div>
@endsection
