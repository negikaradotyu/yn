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
    $categories = Category::get();
    $accessCounter = new AccessCounter();
    $accessCounter->update(['counter' => $counter], ['id' => 0]);
    $questions = DB::table('questionaries')
        ->join('summaries', 'questionaries.id', '=', 'summaries.id')
        ->select('questionaries.question', 'summaries.*')
        ->orderBy('questionaries.created_at', 'DESC')
        ->paginate(10);
    $user=\Auth::user();

    return view('welcome', compact('questions','counter','categories','user'));
})->name('welcome');;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('post')->middleware('allow.guest:post,other_route1,other_route2');
Route::post('/store', [App\Http\Controllers\PostingController::class, 'store'])->name('store');
Route::post('/kekka', [App\Http\Controllers\KekkaController::class, 'kekka'])->name('kekka');
Route::post('/kekka2', [App\Http\Controllers\Kekka2Controller::class, 'kekka2'])->name('kekka2');
Route::post('/kekka3', [App\Http\Controllers\Kekka3Controller::class, 'kekka3'])->name('kekka3');
Route::get('/category/{category}', [App\Http\Controllers\HomeController::class, 'category'])->name('category')->middleware('allow.guest:category,other_route1,other_route2');

Route::get('/topten', [App\Http\Controllers\HomeController::class, 'topten'])->name('topten')->middleware('allow.guest:topten,other_route1,other_route2');
Route::get('/mikaito', [App\Http\Controllers\HomeController::class, 'mikaito'])->name('mikaito')->middleware('allow.guest:topten,other_route1,other_route2');
Route::get('/mypage/{id}', [App\Http\Controllers\MypageController::class, 'mypage'])->name('mypage');
Route::get('/allvotes', [App\Http\Controllers\AllController::class, 'allvotes'])->name('allvotes');
Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search')->middleware('allow.guest:search,other_route1,other_route2');
Route::get('/keijiban', [App\Http\Controllers\KeijibanController::class, 'keijiban'])->name('keijiban')->middleware('allow.guest:keijiban,other_route1,other_route2');
Route::post('/toko', [App\Http\Controllers\KeijibanController::class, 'toko'])->name('toko');

