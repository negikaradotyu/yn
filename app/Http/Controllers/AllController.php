<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaries;
use App\Models\Category;
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
        $records=Records::where('user_id', $user['id'])->orderby('updated_at','DESC')->get();
        //dd($records);
        $count=count($records);
        $questions = DB::table('records')
        ->join('questionaries', 'records.question_id', '=', 'questionaries.id')
        ->select('records.*','questionaries.question')
        ->where('records.user_id', '=', $user['id'])
        ->orderBy('records.created_at', 'DESC')
        ->paginate(10);

        $summaries = DB::table('records')
        ->join('summaries', 'records.question_id', '=', 'summaries.id')
        ->select('records.question_id','summaries.*')
        ->where('records.user_id', '=', $user['id'])
        ->orderBy('records.created_at', 'DESC')
        ->get();
        return view('allvotes',compact('records', 'count', 'questions', 'summaries', 'categories', 'user'));
    }


}

?>