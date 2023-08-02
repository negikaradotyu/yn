<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;


use Illuminate\Support\Facades\Session;
use App\Models\Keijiban;

class KeijibanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
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
    public function keijiban()
    {   
        $user = \Auth::user();
        $categories = Category::get();
        $comments=Keijiban::orderby('created_at', 'DESC')-> paginate(20);
        return view('keijiban', compact('categories', 'user', 'comments'));
    }

    public function toko(Request $request){

        $data=$request->all();
        //dd($data);
        $toko=Keijiban::InsertGetId([
            'id'=> $data['user_id'],
            'user_name' => $data['user_name'],
            'comment'=> $data['toko']
        ]);
        
        return redirect()->route('keijiban')->with('success', '投稿しました');
    }

    
    
}