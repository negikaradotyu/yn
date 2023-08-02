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
        $questions=Questionaries::where('user_id', $user['id'])->orderBy('created_at', 'DESC')->paginate(5);
        $counts=AccessCounter::get();
        $count = $counts->first();
        $counter=$count->counter;
        $questions = DB::table('questionaries')
        ->join('summaries', 'questionaries.id', '=', 'summaries.id')
        ->select('questionaries.*', 'summaries.total')
        ->where('questionaries.user_id', '=', $user['id'])
        ->orderBy('questionaries.created_at', 'DESC')
        ->paginate(5);

        $summaries = DB::table('questionaries')
        ->join('summaries', 'questionaries.id', '=', 'summaries.id')
        ->select('questionaries.id', 'summaries.*')
        ->where('questionaries.user_id', '=', $user['id'])
        ->orderBy('questionaries.created_at', 'DESC')
        ->get();

        //dd($summaries);
        if ($questions !== null) {
            return view('mypage', compact('counter','summaries','questions','count', 'categories', 'user'));
        } else {
            return view('post');
        }
        
    
    }
}

?>