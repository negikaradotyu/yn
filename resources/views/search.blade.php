@extends('layouts.app2') 

@section('category')

<main class="main-menus">
        <div class="contents">
            @if($questions->isEmpty())     
            <p>検索結果はありません。</p>
            @else
            <form method='POST' action="/kekka4" name="kekka4">    
                @csrf
                <input  type="hidden" name="search"  value="{{$searchKeyword}}">
            <div class="question"> 
                <table class=menu-object>
                    <tr>
                        <th rowspan="2" colspan="2" class="waku1">議題</th>
                        <th colspan="3" class="waku2">投票数</th>
                        <th rowspan="2" class="waku5">投票</th>
                    </tr>
                    <tr>
                        <th class="waku3">Yes</th>
                        <th class="waku3">No</th>
                        <th class="waku4">Total</th>
                    </tr>
                    @foreach($questions as $question)
                        <input type='hidden' name='user_id' value="{{ $user->id }}">

                        <tr>
                            <input type='hidden' name='question_id' value="{{ $question->id }}">
                                <td class="icon"><i class="fa-regular fa-comment"></i></td>
                                <td><p>{{ $question->question }}</p></td>
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
                        </tr>
                    @endforeach
                </table>
            </div>  
            <div class="menu-subject">
            <input class="btn btn-primary" type="submit" value="一括投票">
            </form>
            @endif
        </div> 
</main>

@endsection

@section('content')
    
    
<div class="categories">
        @foreach($categories as $category)
        <a href="category{{ $category['category'] }}"><i class="fa-regular fa-clipboard"></i>{{ $category['name'] }}</a>
        @endforeach
        @guest
        @else
        <a href="/mikaito"><i class="fa-solid fa-clipboard"></i>未回答</a>
        @endguest
        
    <a href="/topten"><i class="fa-solid fa-clipboard"></i>Top10</a>
    <a href="/home"><i class="fa-solid fa-house-crack"></i>Go to Home</a>
    </div>

    <form action="/search" method="GET" class="search-form">
        <input name="search" rows="1" cols="10"></input>
        <input type="submit" value="検索">
    </form>

@endsection