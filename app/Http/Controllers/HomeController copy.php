<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaries;
use App\Models\Category;
use App\Models\Summaries;
use App\Models\Records;
use App\Models\AccessCounter;
use Carbon\Carbon;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            Session::start();
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {   
        $user = \Auth::user();
        $categories = Category::get();
        $questions=Questionaries::orderBy('created_at', 'DESC')->take(5)->get();
        $i=count($questions);
        $records=Records::where('user_id', $user['id'])->get();
        //dd($records);
        //dd($questions);
    //access counter
        $counts=AccessCounter::get();
        $count = $counts->first();
        $date=$count->date;
        $counter=$count->counter;
        $ui=$count->id;
        $today=Carbon::today()->toDateString();
        

        if($date==$today && $ui==$user['id']){

        }else{
            $counter++;
            $count->id = $user['id'];
            $count->date = $today;
            $count->counter = $counter;
            $count->save();
    }

            for($a=0; $a<$i; $a++){
                $summaries[]=Summaries::where('id', $questions[$a]['id'])->get();  
            };
            
            if(empty($summaries)){
            return view('post', compact('records','user','questions','categories','counter'));
            }else{
            return view('post', compact('records','user','questions','categories','summaries','counter'));
            };



    }

    
    public function category($category)
    {   
        $user = \Auth::user();
        $records=Records::where('user_id', $user['id'])->get();
        $categories = Category::get();
        $cho=Category::where('choose', $category)->get();
        //dd($cho);

        //access counter
        $counts=AccessCounter::get();
        $count = $counts->first();
        $date=$count->date;
        $counter=$count->counter;
        $ui=$count->id;
        $today=Carbon::today()->toDateString();
        

        if($date==$today && $ui==$user['id']){

        }else{
            $counter++;
            $count->id = $user['id'];
            $count->date = $today;
            $count->counter = $counter;
            $count->save();
    }




        if ($cho->isNotEmpty()) {
            $choose = $cho[0]['name'];
        } else {
            $choose = $category;
        }
        
        if($choose=="top10"){
            $questions = DB::table('questionaries')
            ->join('summaries', 'questionaries.id', '=', 'summaries.id')
            ->select('questionaries.id','questionaries.category','questionaries.question', 'summaries.yes','summaries.no','summaries.total')
            ->orderBy('summaries.total', 'DESC')
            ->paginate(10);
        }elseif($choose=="未回答"){
            $id1_question_ids = Records::where('user_id', $user['id'])->pluck('question_id')->toArray();
            $id2_question_ids = Records::where('user_id', '<>', $user['id'])->pluck('question_id')->toArray();
            
            // id1ではなく、重複しないquestion_idを取得
            $another_records = array_values(array_unique(array_diff($id2_question_ids, $id1_question_ids)));
            
            // $another_recordsを利用して他の処理を行う
            // ...
            
            // $another_recordsを出力する
            
            
            $questions = Questionaries::whereIn('id', $another_records)->paginate(10);
        }else{
            $questions = DB::table('questionaries')
            ->join('summaries', 'questionaries.id', '=', 'summaries.id')
            ->where('questionaries.category', $category)
            ->select('questionaries.id','questionaries.category','questionaries.question', 'summaries.yes','summaries.no','summaries.total')
            ->orderBy('summaries.total', 'DESC')
            ->paginate(10);
        };
        
        if(empty($summaries)){
        return view('category', compact('counter','records','user', 'choose','questions','categories','category' ));
        }else{
            return view('category', compact('counter','records','user', 'choose','questions','categories','category','summaries'));
        };
    }
}