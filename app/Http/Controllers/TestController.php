<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaries;
use Illuminate\Support\Facades\Auth; // Authクラスを追加
use App\Models\Category;
use App\Models\Summaries;
use App\Models\Records;
use Hamcrest\Type\IsNumeric;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $searchKeyword = $request->input('search'); 
        return redirect()->route('show', compact('searchKeyword'));
    }

    public function show(Request $request)
    {
        $searchKeyword = $request->query('searchKeyword'); // クエリパラメータから取得
        $q=Questionaries::where('question', 'LIKE', '%' . $searchKeyword . '%')->get();
        return view('show', compact('searchKeyword', 'q'));
    }

    public function shibori(Request $request)
    {
        $data=$request->all();
        $searchKeyword = $data['options'];
        $q=Questionaries::where('question', $searchKeyword)->get();
        return redirect()->route('show', compact('searchKeyword','q'));
    }
    
};