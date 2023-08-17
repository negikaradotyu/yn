
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main class="main-menus">
    <form action="{{ route('test') }}" method="GET" class="search-form">
        <input name="search" rows="1" cols="10"></input>
        <input type="submit" value="検索">
    </form>
    @if(isset($searchKeyword))
        <p>検索キーワード: {{ $searchKeyword }}</p>
    @endif
    @foreach($q as $p)
        <p>{{$p['question']}}</p>
        @endforeach
    <form action="/shibori" method="POST" class="shiboriform">
    @csrf
    <input name="shibori" rows="1" cols="10"></input>
        <input type="submit" value="focus">
        <input  type="hidden" name="options"  value={{$searchKeyword}}>
    </form>
</main>
</body>
</html>

