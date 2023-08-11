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
    public function kekka2(Request $request)
    {
        //dd($category);
        $data=$request->all();
        //dd($data);
        $chooseJson = $data['choose'];
        $chooseArray = json_decode($chooseJson, true);
        
        $choose = $chooseArray['choose']; // "politics"

        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $summaryId = intval($key);
                $voteType = intval($value);

                if ($voteType === 1) {
                    Summaries::where('id', $summaryId)->increment('yes');
                } elseif ($voteType === 2) {
                    Summaries::where('id', $summaryId)->increment('no');
                }

                Summaries::where('id', $summaryId)->increment('total');
            }
        }

        $user = \Auth::user();
        if (!$user) {
            $user = (object) [
                'id' => 0,
                'name' => 'guest'
            ];
        }

        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $questionId = intval($key);
                $voteType = intval($value);

                $existingRecord = Records::where('user_id', $user->id)
                    ->where('question_id', $questionId)
                    ->first();

                if (!$existingRecord) {
                    $newRecordId = Records::insertGetId([
                        'user_id' => $user->id,
                        'question_id' => $questionId,
                    ]);
                }

                $record = Records::where('user_id', $user->id)
                    ->where('question_id', $questionId)
                    ->first();

                if ($record) {
                    if ($voteType === 1) {
                        $record->yes = $record->yes ? $record->yes + 1 : 1;
                        $record->total = $record->total ? $record->total + 1 : 1;
                    } elseif ($voteType === 2) {
                        $record->no = $record->no ? $record->no + 1 : 1;
                        $record->total = $record->total ? $record->total + 1 : 1;
                    }

                    $record->save();
                }
            }
        }


        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $questionId = intval($key);
                $voteType = intval($value);

                if ($user->id !== 0) {
                    $existingRecord = Records::where('user_id', $user->id)
                        ->where('question_id', $questionId)
                        ->first();

                    if (!$existingRecord) {
                        $newRecordId = Records::insertGetId([
                            'user_id' => $user->id,
                            'question_id' => $questionId,
                        ]);
                    }
                }

                $record = Records::where('user_id', $user->id)
                    ->where('question_id', $questionId)
                    ->first();

                if ($record) {
                    if ($voteType === 1) {
                        $record->yes = $record->yes ? $record->yes + 1 : 1;
                        $record->total = $record->total ? $record->total + 1 : 1;
                    } elseif ($voteType === 2) {
                        $record->no = $record->no ? $record->no + 1 : 1;
                        $record->total = $record->total ? $record->total + 1 : 1;
                    }

                    $record->save();
                }
            }
        }



        return redirect()->route('category', ['category' => $choose]);

            //return view('category',compact('choose','questions','user'));
    }
    
};