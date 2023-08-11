<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaries;
use App\Models\Category;
use App\Models\AccessCounter;
use App\Models\Summaries;
use App\Models\Records;
use Illuminate\Support\Facades\DB;

class AllController extends Controller
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
    public function allvotes()
    {   
        $user = \Auth::user();
        $categories = Category::get();
        $counts=AccessCounter::get();
        $count = $counts->first();
        $counter=$count->counter;
        $questions = DB::table('questionaries')
        ->join('records', 'questionaries.id', '=', 'records.question_id')
        ->select('questionaries.question', 'records.*')
        ->where('records.user_id', '=', $user['id'])
        ->orderBy('records.created_at', 'DESC')
        ->paginate(10);

        // change created_at->Carbon instance
        foreach ($questions as $question) {
            $question->created_at = \Carbon\Carbon::parse($question->created_at);
        }

        $summaries = DB::table('records')
        ->join('summaries', 'records.question_id', '=', 'summaries.id')
        ->select('records.question_id', 'summaries.*')
        ->where('records.user_id', '=', $user['id'])
        ->orderBy('records.created_at', 'DESC')
        ->get();


        $choose['name']="My Page";
        //the number of your vote from Records DB
        $num=Records::where('user_id',$user['id'])->get();
        $theNum=count($num);
        //the rate of vote from questionaries DB
        $theNumOfQuestionaries=Questionaries::get();
        
        $theNum2=count($theNumOfQuestionaries);
        $rateOfVote=number_format($theNum/$theNum2*100,1);
            return view('allvotes', compact('rateOfVote', 'theNum', 'counter','summaries','questions','count', 'categories', 'user','choose'));
    
    }
}

?>