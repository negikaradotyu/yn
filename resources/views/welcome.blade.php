@extends('layouts.app')

@section('content5')
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
        <textarea name="search" rows="1" cols="10"></textarea>
        <input type="submit" value="検索">
    </form>
@endsection

@section('content2')
    <div class="phrase"><p>カテゴリーを選び、投稿してください</p></div>
    
        <form method='POST' action="/store" name="store">
                @csrf
            <div class="category">
                <input  type="hidden" name="options"  value="non">
                <input type="radio" class="btn-check" name="options" value="like" id="option1" autocomplete="off">
                <label class="btn btn-outline-danger" for="option1">好き嫌い</label>
                <input type="radio" class="btn-check" name="options" value="politics" id="option2" autocomplete="off">
                <label class="btn btn-outline-danger" for="option2">政治</label>
                <input type="radio" class="btn-check" name="options" value="economic" id="option3" autocomplete="off">
                <label class="btn btn-outline-danger" for="option3">経済</label>
                <input type="radio" class="btn-check" name="options" value="entertain" id="option4" autocomplete="off">
                <label class="btn btn-outline-danger" for="option4">芸能</label>
                <input type="radio" class="btn-check" name="options" value="other" id="option5" autocomplete="off">
                <label class="btn btn-outline-danger" for="option5">その他</label>
                
            </div>
            <div class="question">
                    <input type='hidden' name='user_id' value=0>
                    <input  type="hidden" name="answer"  value=0>
                    <textarea maxlength=50 class="form-control"  name="question" rows="2" placeholder="enter a question, 上限50文字"></textarea>
                    <div class="phrase"><p>あなたの投票</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="answer" id="yesOption_global" value="1">
                        <label class="form-check-label" for="yesOption_global">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="answer" id="noOption_global" value="2">
                        <label class="form-check-label" for="noOption_global">No</label>
                        </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="answer" id="noOption_global" value="0">
                        <label class="form-check-label" for="noOption_global">無効</label>
                        </div>
                        <input class="btn btn-primary" type="submit" value="投票">

                    
                    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@elseif(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
@endif
            </div>
        </form>
    
@endsection

@section('content3')
<main class="main-menus">
<form method='POST' action="/kekka3" name="kekka3">    
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
    @foreach($questions as $question)
        <input type='hidden' name='user_id' value=0>
        <tr>
            <input type='hidden' name='question_id' value="{{ $question->id }}">
                <td><p><i class="fa-regular fa-comment"></i>{{ $question->question }}</p></td>
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
    @endforeach
</table>
    <div class="btn-vote">  
    <input class="btn btn-primary " type="submit" value="一括投票">
    </div>
</form>
<div class="links">{{ $questions->links() }}</div>

@endsection

