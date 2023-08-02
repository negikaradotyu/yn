@extends('layouts.app2') 

@section('content4')

<main class="main-menus">
    <div class="menu-title4">
        <div class="menu-subject">
            <div class="myprofile">
            Mypage
            </div>
            </div>


</div>

    <div class="menu-subject">
    投票一覧　（総数：{{$count}}）
    </div>

    <table class=menu-object>
    <tr>
        <th class="waku1">question</th>
        <th class="waku2">done</th>
        <th class="waku3">yes</th>
        <th class="waku3">no</th>
        <th class="waku4">total</th>
    </tr>

    @foreach($questions as $question)
        <tr>
            <td>{{ $question->question }}</td>
            @if($question->yes > 0)
                <td>はい</td>
                @elseif($question->no > 0)
                <td>いいえ</td>
            @endif
            @foreach($summaries as $summary)
                @if($question->question_id == $summary->id)
                <td>{{$summary->yes}}</td>
                <td>{{$summary->no}}</td>
                <td>{{$summary->total}}</td>
                @endif
            @endforeach
        </tr> 
    @endforeach
</table>
{{ $questions->links() }}

<div class="allvotes">
<a href="/mypage/{{$user['id']}}">あなたの質問一覧</a>
</div>
</main>    

@endsection
@section('content')
    <div class="categories">
        @foreach($categories as $category)
        <a href="category{{ $category['category'] }}">{{ $category['name'] }}</a>
        @endforeach
        <a href="/home">What's New!</a>
    </div>

    <form action="/search" method="GET">
  <textarea name="search" rows="4" cols="50"></textarea>
  <br>
  <input type="submit" value="検索">
</form>

@endsection