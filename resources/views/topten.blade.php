@extends('layouts.app2') 

@section('category')
<main class="main-menus">
<form method='POST' action="/kekka2">
@csrf
<table class=menu-object>
    <tr>
        <th rowspan="2" class="waku1">議題</th>
        <th colspan="3" class="waku2">投票数</th>
        <th rowspan="2" class="waku5">投票</th>
    </tr>
    <tr>
        <th class="waku3">Yes</th>
        <th class="waku3">No</th>
        <th class="waku4">Total</th>
    </tr>
        <input type='hidden' name='choose' value="{{$choose}}">
    @foreach($questions as $question)
        <input type='hidden' name='user_id' value="{{ $user->id }}">
        <tr>
            <input type='hidden' name='question_id' value="{{ $question->id }}">
                <td><p><i class="fa-regular fa-comment"></i>{{ $question->question }}</p></td>
                <td class="centerize"><?php echo $question->yes; ?></td>
                <td class="centerize"><?php echo $question->no; ?></td>
                <td class="centerize"><?php echo $question->total; ?></td>
                @php
                    $d = 0;
                @endphp
                @if($user->id==0)
                
                @else
                    @foreach($records as $record)
                        @if($record->id==$question->id)
                            @php
                                $d = 1; 
                            @endphp
                            @break
                        @endif
                    @endforeach
                @endif
                @if($d==1)
                    <td class="centerize">投票済み</td>
                @else($d==0)
                        <td  class="centerize">
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $question->id}}" id="yesOption_{{ $question->id}}" value="1">
                            <label class="form-check-label" for="yesOption_{{ $question->id }}">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $question->id}}" id="noOption_{{ $question->id }}" value="2">
                            <label class="form-check-label" for="noOption_{{ $question->id }}">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $question->id }}" id="invalidOption_{{$question->id }}" value="0">
                            <label class="form-check-label" for="invalidOption_{{ $question->id }}">無効</label>
                            </div>
                        </td>
                @endif
            @endforeach
</table>
        <tr><input class="btn btn-primary" type="submit" value="一括投票"></tr>
</form>
        @if($choose<>"Top10")
        {{ $questions->links() }}
        @endif
</main>    

@endsection
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