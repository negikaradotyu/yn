<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaries;
use App\Models\Category;
use App\Models\Summaries;
use App\Models\Records;
use Hamcrest\Type\IsNumeric;

class Kekka3Controller extends Controller
{

    public function kekka3(Request $request)
    {

        $data=$request->all();
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
                    }elseif($data[$key]==2){
                        $all=Summaries::where('id', $key)->get();
                        $no=$all[0]['no']+1;
                        $total=$all[0]['total']+1;
                        Summaries::where('id', $key)->update(['no' => $no]);
                        Summaries::where('id', $key)->update(['total' => $total]);
                        Questionaries::where('id', $key)->update(['total' => $total]);
                        //$yes=[];
                    }else{};
                };
            };
        return redirect()->route('welcome');
    }
    
};