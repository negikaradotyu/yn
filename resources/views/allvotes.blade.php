@extends('layouts.app2') 

@section('category')

<main class="main-menus">
    <div class="menu-title4">
        総投票数   {{$theNum}} 票 <i class="fa-solid fa-arrows-rotate fa-spin" style="color: #8e9013;"></i>
        投票率 {{$rateOfVote}} <i class="fa-light fa-percent fa-spin" style="color: #535009;"></i></i>
    </div>

<table class=menu-object>
<tr>
        <th rowspan="2" class="waku1">投票一覧</th>
        <th rowspan="2" class="time">投票日</th>
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
            @foreach($summaries as $summary)
                @if($question->question_id == $summary->id)
                <td style="color: red; background-color: rgb(225, 215, 85); font-weight:700 !important;">{{$summary->yes}}</td>
                <td>{{$summary->no}}</td>
                <td>{{$summary->total}}</td>
                @endif
            @endforeach
        @elseif($question->no > 0)
            @foreach($summaries as $summary)
                @if($question->question_id == $summary->id)
                <td>{{$summary->yes}}</td>
                <td style="color: red; background-color: rgb(225, 215, 85);font-weight:700;">{{$summary->no}}</td>
                <td>{{$summary->total}}</td>
                @endif
            @endforeach
        @else
            @foreach($summaries as $summary)
                @if($question->question_id == $summary->id)
                <td>{{$summary->yes}}</td>
                <td>{{$summary->no}}</td>
                <td>{{$summary->total}}</td>
                @endif
            @endforeach
        @endif

    </tr> 
    @endforeach   
</table>
<div class="container">
    <div class="caution">あなたの投票</div>
</div>
<div class="paginate">
    {{ $questions->links() }}</div>


<div class="allvotes">
    <a href="/mypage/{{$user['id']}}">議題一覧へ</a>
</div>
</main>    

@endsection
@section('content')
    <div class="categories">
        @foreach($categories as $category)
        <a href="/category{{ $category['category'] }}"><i class="fa-regular fa-clipboard"></i>{{ $category['name'] }}</a>
        @endforeach
        <a href="/home">What's New!</a>
    </div>

    


@endsection