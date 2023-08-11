<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaries;
use App\Models\Category;
use App\Models\Summaries;
use App\Models\Records;
use Hamcrest\Type\IsNumeric;

class Kekka2Controller extends Controller
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
   
    public function kekka2(Request $request, $category)
    {
        //dd($category);
        $data=$request->all();
        dd($data);
        $user = \Auth::user();
        if (!$user) {
            $user = (object) [
                'id' => 0,
                'name' => 'guest'
            ];
        }
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
                        if($user['id']<>0){
                            $records=Records::insertGetId([
                                'user_id'=> $user['id'],
                                'question_id'=> $key,
                                'yes'=> $yes,
                                'no'=> $total
                        ]);
                    }else{
                        
                    }

                    }elseif($data[$key]==2){
                        $all=Summaries::where('id', $key)->get();
                        $no=$all[0]['no']+1;
                        $total=$all[0]['total']+1;
                        Summaries::where('id', $key)->update(['no' => $no]);
                        Summaries::where('id', $key)->update(['total' => $total]);
                        Questionaries::where('id', $key)->update(['total' => $total]);
                        //$yes=[];
                        $records=Records::insertGetId([
                            'user_id'=> $user['id'],
                            'question_id'=> $key,
                            'yes'=> $no,
                            'no'=> $total
                        ]);
                    }else{};
                };

            };
            return redirect()->route('category', ['category' => $category])->with('user', $user);
    }
    
};