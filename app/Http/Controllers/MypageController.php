<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaries;
use App\Models\Category;
use App\Models\AccessCounter;
use App\Models\Summaries;
use App\Models\Records;
use Illuminate\Support\Facades\DB;

class MypageController extends Controller
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
    public function mypage()
    {   
        $user = \Auth::user();
        $categories = Category::get();
        $counts=AccessCounter::get();
        $count = $counts->first();
        $counter=$count->counter;
        $questions = DB::table('questionaries')
        ->join('summaries', 'questionaries.id', '=', 'summaries.id')
        ->select('questionaries.*', 'summaries.total')
        ->where('questionaries.user_id', '=', $user['id'])
        ->orderBy('questionaries.created_at', 'DESC')
        ->paginate(10);

        // change created_at->Carbon instance
        foreach ($questions as $question) {
            $question->created_at = \Carbon\Carbon::parse($question->created_at);
        }

        $summaries = DB::table('questionaries')
        ->join('summaries', 'questionaries.id', '=', 'summaries.id')
        ->select('questionaries.id', 'summaries.*')
        ->where('questionaries.user_id', '=', $user['id'])
        ->orderBy('questionaries.created_at', 'DESC')
        ->get();
        $choose['name']="My Page";
        //the number of your vote from Records DB
        $num=Records::where('user_id',$user['id'])->get();
        $theNum=count($num);
        //the rate of vote from questionaries DB
        $theNumOfQuestionaries=Questionaries::get();
        
        $theNum2=count($theNumOfQuestionaries);
        $rateOfVote=number_format($theNum/$theNum2*100,1);
            return view('mypage', compact('rateOfVote', 'theNum', 'counter','summaries','questions','count', 'categories', 'user','choose'));
    
    }
}

?>