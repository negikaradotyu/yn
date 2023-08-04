@extends('layouts.app2') 

@section('category')
<main class="main-menus">
<form method='POST' action="/kekka2/{{$choose}}">
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
        <input type='hidden' name='choose' value="{{ $choose}}">
        
        <!-- {{$a=0}} -->
        @if ($questions->isEmpty()) 
            <td>未回答のものはありません</td>
        @endif
        @foreach($questions as $question) 
            <!-- {{$done=0}} -->
        <div class="category">
            <input  type="hidden" name="options"  value="{{ $choose }}">
            <input type='hidden' name='user_id' value="{{ $user['id'] }}">
        </div>
        <tr>
            <td>{{ $question->question }}</td>
            <input type='hidden' name='question_id' value="{{ $question->id }}">
             @foreach($records as $record)                
                            @if($record['question_id']==$question->id && $user['id']==$record['user_id'])
                            <td class="centerize"> </td>
                            <td class="centerize"><?php echo $question->yes; ?></td>
                            <td class="centerize"><?php echo $question->no; ?></td>
                            <td class="centerize"><?php echo $question->total; ?></td>
                            <td class="centerize"></td>
                            <!-- {{$done=1}}<br> -->
                            @break
                            @else
                            <!-- {{$done=0}}<br> -->
                            @endif
                @endforeach
            @if($done==0)   
                            <td class="centerize"><?php echo $question->yes; ?></td>
                            <td class="centerize"><?php echo $question->no; ?></td>
                            <td class="centerize"><?php echo $question->total; ?></td>
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
                </tr>  
                <!-- {{$a++}} -->
            @endforeach
        </table>
        <tr><input class="btn btn-primary" type="submit" value="一括投票"></tr>
        </form>
        @if($choose<>"top10")
        {{ $questions->links() }}
        @endif
</main>    

@endsection
@section('content')
    <div class="categories">
    @foreach($categories as $category)
    <a href="{{ route('category', ['category' => $category['choose'], 'user' => $user]) }}">{{ $category['name'] }}</a>
@endforeach
        <a href="/home">Go to Home</a>
        <form action="/search" method="GET" class="search-form">
        <textarea name="search" rows="1" cols="10"></textarea>
        <input type="submit" value="検索">
    </form>
    </div>
@endsection