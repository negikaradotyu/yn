<?php

use Illuminate\Support\Facades\Route;
use App\Models\AccessCounter;
use Illuminate\Http\Request;
use App\Models\Questionaries;
use App\Models\Category;
use App\Models\Summaries;
use App\Models\Records;
use Carbon\Carbon;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $count = AccessCounter::get()->first();
    $counter=$count['counter']+1;
    $user = \Auth::user();
    if(empty($user)){
        //dd($counter);
        
            // AccessCounterモデルをインスタンス化
$accessCounter = new AccessCounter();

// updateメソッドを呼び出し
$accessCounter->update(['counter' => $counter], ['id' => 0]);
        //dd($counter);
    }
    else{
    // AccessCounterモデルをインスタンス化
$accessCounter = new AccessCounter();

// updateメソッドを呼び出し
$accessCounter->update(['counter' => $counter], ['id' => $user['id']]);
    };

    $categories = Category::get();
    $questions=Questionaries::orderBy('created_at', 'DESC')->take(5)->get();
    $i=count($questions);
    $counts=AccessCounter::get();
    $count = $counts->first();
    $date=$count->date;
    $counter=$count->counter;
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
        return view('welcome', compact('user','questions','categories','counter'));
        }else{
        return view('welcome', compact('user','questions','categories','summaries','counter'));
        };
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('post');
Route::post('/store', [App\Http\Controllers\PostingController::class, 'store'])->name('store');
Route::post('/kekka', [App\Http\Controllers\KekkaController::class, 'kekka'])->name('kekka');
Route::post('/kekka2/{category}', [App\Http\Controllers\Kekka2Controller::class, 'kekka2'])->name('kekka2');
Route::get('/category/{category}', [App\Http\Controllers\HomeController::class, 'category'])->name('category');

Route::get('/top10', [App\Http\Controllers\HomeController::class, 'topten'])->name('topten');
Route::get('/mypage/{id}', [App\Http\Controllers\MypageController::class, 'mypage'])->name('mypage');
Route::get('/allvotes', [App\Http\Controllers\AllController::class, 'allvotes'])->name('allvotes');
Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
Route::get('/keijiban', [App\Http\Controllers\KeijibanController::class, 'keijiban'])->name('keijiban');
Route::post('/toko', [App\Http\Controllers\KeijibanController::class, 'toko'])->name('toko');

