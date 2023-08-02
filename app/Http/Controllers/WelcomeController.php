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
    public function index(Request $request)
    {   
        $categories = Category::get();
        $questions=Questionaries::orderBy('created_at', 'DESC')->take(5)->get();
        $i=count($questions);
        //dd($records);
        //dd($questions);
    //access counter
        $counts=AccessCounter::get();
        $count = $counts->first();
        $date=$count->date;
        $counter=$count->counter;
        $ui=$count->id;
        $today=Carbon::today()->toDateString();
        

        if($date==$today){

        }else{
            $counter++;
            $count->date = $today;
            $count->counter = $counter;
            $count->save();
    }

            for($a=0; $a<$i; $a++){
                $summaries[]=Summaries::where('id', $questions[$a]['id'])->get();  
            };
            
            if(empty($summaries)){
            return view('welocme', compact('questions','categories','counter'));
            }else{
            return view('welcome', compact('questions','categories','summaries','counter'));
            };
    }
}