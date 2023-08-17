<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaries;
use App\Models\Category;
use App\Models\Records;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\IsEmpty;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $user = \Auth::user();
        
        if (!$user) {
            $user = (object) [
                'id' => 0,
                'name' => 'guest'
            ];
        }
        $searchKeyword = $request->session()->get('searchKeyword');
        if(Empty($searchKeyword)){
        $searchKeyword = $request->query('search');
        }else{$searchKeyword = $request->session()->get('searchKeyword');
        };//dd($searchKeyword);
        $counter = session('counter');
        // 検索キーワードを使ってデータベースクエリを実行
        $records=Records::where('user_id', $user->id)->get();
        $questions=DB::table('questionaries')
        ->join('summaries', 'questionaries.id', '=', 'summaries.id')
        ->select('questionaries.question', 'summaries.*')
        ->where('question', 'LIKE', '%' . $searchKeyword . '%')
        ->orderBy('summaries.updated_at', 'DESC')
        ->paginate(5);
        //dd($records);
            //dd($results);
        // 検索結果をビューに渡して表示するなどの処理を行う
           // dd($results);
           $categories = Category::get();
           $choose['name']="検索結果";
           //dd($searchKeyword);
           // search メソッド内

           return view('search', compact('searchKeyword','questions', 'records','choose', 'counter', 'user', 'categories'));
    }
}

?>