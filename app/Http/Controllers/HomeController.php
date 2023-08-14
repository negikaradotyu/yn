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
        $this->middleware('auth')
        ->except('topten', 'mikaito','index', 'post', 'keijiban', 'category','search','home');
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
        
        if (!$user) {
            $user = (object) [
                'id' => 0,
                'name' => 'guest'
            ];
        }
        $categories = Category::get();
        
        $counts=AccessCounter::get();
        $count = $counts->first();
        $date=$count->date;
        $counter=$count->counter;
        $ui=$count->id;
        $today=Carbon::today()->toDateString();
        
        //if $user id=0, $counter++;
        if($user->id==0){
            $counter++;
            $count->id = 0;
            $count->date = $today;
            $count->counter = $counter;
            $count->save();
        }elseif($date==$today && $ui==$user['id']){

        }else{
            $counter++;
            $count->id = 0;
            $count->date = $today;
            $count->counter = $counter;
            $count->save();
        };

        
        $questions = DB::table('questionaries')
        ->join('summaries', 'questionaries.id', '=', 'summaries.id')
        ->select('questionaries.question', 'summaries.*')
        ->orderBy('questionaries.created_at', 'DESC')
        ->take(5)
        ->get();
        
        if($user['id']>0) {
            $records = DB::table('questionaries')
            ->join('records', 'questionaries.id', '=', 'records.question_id')
            ->select('questionaries.*', 'records.user_id', 'records.question_id')
            ->where( 'records.user_id',$user['id'])
            ->get();
        }else{
            $records = DB::table('questionaries')
            ->join('records', 'questionaries.id', '=', 'records.question_id')
            ->select('questionaries.*', 'records.user_id', 'records.question_id')
            ->get();
        }  
        return view('post', compact('categories','records','user','questions','counter'));
    }

    
    public function category($category)
    {   
        $user = \Auth::user();
        if (!$user) {
            $user = (object) [
                'id' => 0,
                'name' => 'guest'
            ];
        }
        $choose=Category::where('choose',$category)->first();
        // get counter
        $categories=Category::get();
        $counts=AccessCounter::get();
        $count = $counts->first();
        $counter=$count->counter;
        //question, yes, no , total
        $questions = DB::table('questionaries')
        ->join('summaries', 'questionaries.id', '=', 'summaries.id')
        ->select('questionaries.question', 'summaries.*')
        ->where('questionaries.category', $choose['choose'])
        ->orderBy('questionaries.updated_at', 'DESC')
        ->paginate(10);
        //records
        if($user->id<>0) {
            $records = DB::table('questionaries')
            ->join('records', 'questionaries.id', '=', 'records.question_id')
            ->select('questionaries.*', 'records.user_id', 'records.question_id')
            ->where( 'records.user_id',$user['id'])
            ->get();
        }else{
            $records = DB::table('questionaries')
            ->join('records', 'questionaries.id', '=', 'records.question_id')
            ->select('questionaries.*', 'records.user_id', 'records.question_id')
            ->where('records.user_id', '!=', $user->id)
            ->get();
        }  
        return view('category', compact('choose','categories','records','user','questions','counter'));        
    }

    //mikaito and topten
    public function topten()
    {   
        $user = \Auth::user();
        if (!$user) {
            $user = (object) [
                'id' => 0,
                'name' => 'guest'
            ];
        }
        $choose['name'] = "Top10";
        // get counter
        $categories=Category::get();
        $counts=AccessCounter::get();
        $count = $counts->first();
        $counter=$count->counter;
        //question, yes, no , total
        $questions = DB::table('questionaries')
        ->join('summaries', 'questionaries.id', '=', 'summaries.id')
        ->select('questionaries.question', 'summaries.*')
        ->orderBy('summaries.total', 'DESC')
        ->take(10)
        ->get();
        //records
            $records = DB::table('questionaries')
            ->join('records', 'questionaries.id', '=', 'records.question_id')
            ->select('questionaries.*', 'records.user_id', 'records.question_id')
            ->where('records.user_id', '!=', $user->id)
            ->get();
        
        return view('category', compact('choose','categories','records','user','questions','counter'));        
    }
}
