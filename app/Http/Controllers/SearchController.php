<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaries;
use App\Models\Category;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $user = \Auth::user();
        $searchKeyword = $request->query('search');

        // 検索キーワードを使ってデータベースクエリを実行
        $results = Questionaries::where('question', 'LIKE', '%' . $searchKeyword . '%')->paginate(10);
            //dd($results);
        // 検索結果をビューに渡して表示するなどの処理を行う
           // dd($results);
           $categories = Category::get();
        return view('search', compact('results','user', 'categories'));
    }
}

?>