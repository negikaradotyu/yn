<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaries;
use App\Models\Category;
use App\Models\Summaries;
use App\Models\Records;
use Hamcrest\Type\IsNumeric;

class KekkaController extends Controller
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
   
    public function kekka(Request $request)
    {
        $data=$request->all();
        $user = \Auth::user();
        $keys=array_keys($data);
        //dd($data);
            foreach($keys as $key){
                if(is_numeric($key)){
                    if($data[$key]==1){
                        $all=Summaries::where('id', $key)->get();
                        $yes=$all[0]['yes']+1;
                        $total=$all[0]['total']+1;
                        Summaries::where('id', $key)->update(['yes' => $yes]);
                        Summaries::where('id', $key)->update(['total' => $total]);
                        Questionaries::where('id', $key)->update(['total' => $total]);

                        //$yes=[];
                        $records=Records::insertGetId([
                            'user_id'=> $user['id'],
                            'question_id'=> $key,
                            'yes'=> 1
                        ]);

                    }elseif($data[$key]==2){
                        $all=Summaries::where('id', $key)->get();
                        $no=$all[0]['no']+1;
                        $total=$all[0]['total']+1;
                        Summaries::where('id', $key)->update(['no' => $no]);
                        Summaries::where('id', $key)->update(['total' => $total]);
                        Questionaries::where('id', $key)->update(['total' => $total]);
                        //$yes=[];
                        $record=Records::insertGetId([
                            'user_id'=> $user['id'],
                            'question_id'=> $key,
                            'no'=>1
                        ]);
                    }else{};
                };
            };
        return redirect()->route('post', compact('user'));
    }
    
};