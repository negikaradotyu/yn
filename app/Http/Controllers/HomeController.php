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
        $choose=Category::where('choose',$category)->first();
        dd($choose);
        // get counter
        $categories=Category::get();
        $counts=AccessCounter::get();
        $count = $counts->first();
        $counter=$count->counter;
        //question, yes, no , total
        $questions = DB::table('questionaries')
        ->join('summaries', 'questionaries.id', '=', 'summaries.id')
        ->select('questionaries.question', 'summaries.*')
        ->where('questionaries.category', $choose)
        ->orderBy('questionaries.updated_at', 'DESC')
        ->paginate(10);
        //records
        $records = DB::table('questionaries')
        ->join('records', 'questionaries.id', '=', 'records.question_id')
        ->select('questionaries.*', 'records.user_id', 'records.question_id')
        ->where( 'records.user_id',$user['id'])
        ->get();
        //dd($records);
        return view('category', compact('choose','categories','records','user','questions','counter'));        
    }
}
