@extends('layouts.app2') 

@section('content2')
<main class="main-menus">
    <div class="menu-title4">
        <div class="menu-subject">
            {{$choose}}
        </div>
    </div>
<form method='POST' action="/kekka2/{{$choose}}">
@csrf
<table class=menu-object>
    <tr>
        <th rowspan="2" class="waku1">質問</th>
        <th rowspan="2" class="waku2"></th>
        <th colspan="3" class="waku2">投票数</th>
        <th rowspan="2" class="waku5">投票</th>
    </tr>
    <tr>
        <th class="waku3">はい</th>
        <th class="waku3">いいえ</th>
        <th class="waku4">合計</th>
        
    </tr>

        <input type='hidden' name='choose' value="{{ $category}}">
        <tr><input class="btn btn-primary" type="submit" value="一括投票"></tr>
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
                            <td class="centerize">投票済</td>
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
            <td class="centerize">未投票</td>
                            <td class="centerize"><?php echo $question->yes; ?></td>
                            <td class="centerize"><?php echo $question->no; ?></td>
                            <td class="centerize"><?php echo $question->total; ?></td>
                            <td  class="centerize">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="{{ $question->id}}" id="yesOption_{{ $question->id}}" value="1">
                                <label class="form-check-label" for="yesOption_{{ $question->id }}">はい</label>
                                </div>

                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="{{ $question->id}}" id="noOption_{{ $question->id }}" value="2">
                                <label class="form-check-label" for="noOption_{{ $question->id }}">いいえ</label>
                                </div>

                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="invalidOption_{{$question->id }}" value="0">
                                <label class="form-check-label" for="invalidOption_{{ $question->id }}">無効にする</label>
                                </div>
                            </td>
                @endif
                </tr>  
                <!-- {{$a++}} -->
            @endforeach
        </table>
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

        <a href="/home">What's New!</a>
        <a href="/home">Go to Home</a>
    </div>
@endsection