<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CounterController extends Controller
{
    public function index(Request $request)
    {
        // Redisにアクセスカウントを保存
        Redis::incr('counter');

        // カウンターの値を取得
        $counter = Redis::get('counter');

        // ビューを表示
        return view('counter', ['counter' => $counter]);
    }
}
?>
