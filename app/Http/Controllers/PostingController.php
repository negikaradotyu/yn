<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaries;
use App\Models\Category;
use App\Models\Summaries;
use App\Models\Records;

class PostingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function store(Request $request)
    {
        if ($request->filled('question')) {
        $rules = [
            'question' => 'required'
        ];
    
        // バリデーションを実行します
        $this->validate($request, $rules);
    
        // バリデーションに成功した場合、処理を行います
        // ...
    
        // 元のページにリダイレクトします
        $data = $request->all();
        //dd($data);
//自分の答えを$yesnoに代入。
        $yesno = $data['answer'];
//質問の最新5件を取得。
        
//$yesnoが１なら
        if($yesno==1){
    //DB：Questionariesに追加、Yesコラムは１。    
            $question_id = Questionaries::insertGetId([
                'question' => $data['question'],
                 'user_id' => $data['user_id'], 
                 'yes' => 1, 
                 'no' => 0, 
                 'total'=>1,
                 'category' => $data['options']
                ]);
    //db:Summariesにも追加、Yesコラムは１
            $summary_id=Summaries::insertGetId(['yes'=> 1, 'no'=> 0, 'total'=>1
            ]);
    //db:Recordsにも追加。ID=question_idとする。
            $record_id=Records::insertGetId([
                'user_id' => $data['user_id'], 
                'yes'=> 1,
                'no'=> 0,
                'total'=> 1,
                'question_id'=> $question_id
            ]);
        }elseif($yesno==2){
            $question_id = Questionaries::insertGetId([
            'question' => $data['question'],
             'user_id' => $data['user_id'], 
             'yes' => 0, 
             'no' => 1, 
             'total'=>1,
             'category' => $data['options']
             ]);
             $summary_id=Summaries::insertGetId(['yes'=> 0, 'no'=> 1, 'total'=>1
            ]);
            $record_id=Records::insertGetId([
                'user_id' => $data['user_id'], 
                'yes'=> 0,
                'no'=> 1,
                'total'=> 1,
                'question_id'=> $question_id
            ]);
        }elseif($yesno==0){
            $question_id = Questionaries::insertGetId([
                'question' => $data['question'],
                 'user_id' => $data['user_id'], 
                 'category' => $data['options'],
                 'yes'=> 0,
                'no'=> 0,
                'total'=> 0,
                ]);
                $summary_id=Summaries::insertGetId(['yes'=> 0, 'no'=> 0, 'total'=>0
                ]);
                $record_id=Records::insertGetId([
                    'user_id' => $data['user_id'], 
                    'yes'=> 0,
                    'no'=> 0,
                    'total'=> 0,
                    'question_id'=> $question_id
                ]);
        };
        $questions=Questionaries::orderBy('created_at', 'DESC')->take(5)->get();  
        return redirect()->route('post')->with('success', '質問しました');
        }else{
        // textareaが空の場合の処理
        return redirect()->route('post')->with('error', '何も質問してません');
        }
    }

};