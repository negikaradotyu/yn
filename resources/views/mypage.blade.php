@extends('layouts.app2') 

@section('category')

<main class="main-menus">
    <div class="menu-title4">
        総投票数   {{$theNum}} 票 <i class="fa-solid fa-arrows-rotate fa-spin" style="color: #8e9013;"></i>
        投票率 {{$rateOfVote}} <i class="fa-light fa-percent fa-beat-fade" style="color: #7f8d1c;"></i>
    </div>

<table class=menu-object>
<tr>
        <th rowspan="2" class="waku1">あなたの議題一覧</th>
        <th rowspan="2" class="time">投稿日</th>
        <th rowspan="2" class="wakuYour">あなた</th>
        <th colspan="3" class="waku2">投票数</th>
        
    </tr>
    <tr>
        <th class="waku3">Yes</th>
        <th class="waku3">No</th>
        <th class="waku4">Total</th>
    </tr>

    @foreach($questions as $question)
    <tr>
        <td class="gidai"><i class="fa-regular fa-comment"></i>{{ $question->question }}</td>
        <td>{{ $question->created_at->format('Y-m-d') }}</td>
        @if($question->yes > 0)
            <td>Yes</td>
        @elseif($question->no > 0)
            <td>No</td>
        @else <td>無</td>
        @endif
        @foreach($summaries as $summary)
            @if($question->id == $summary->id)
            <td>{{$summary->yes}}</td>
            <td>{{$summary->no}}</td>
            <td>{{$summary->total}}</td> 
            @endif
        @endforeach
    </tr> 
        @endforeach
</table>
<div class="paginate">
    {{ $questions->links() }}</div>


<div class="allvotes">
    <a href="/allvotes">投票一覧へ</a>
</div>
</main>    

@endsection
@section('content')
    <div class="categories">
        @foreach($categories as $category)
        <a href="/category{{ $category['category'] }}"><i class="fa-regular fa-clipboard"></i>{{ $category['name'] }}</a>
        @endforeach
        <a href="/mikaito"><i class="fa-solid fa-clipboard"></i>未回答</a>
        <a href="/topten"><i class="fa-solid fa-clipboard"></i>Top10</a>
        <a href="/home"><i class="fa-solid fa-house-crack"></i>Go to Home</a>
    </div>

    


@endsection