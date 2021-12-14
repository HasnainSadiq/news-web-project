<?php

use App\Http\Controllers\ApiNewsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Models\News;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Protected Routes
    Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/news', function (Request $request) {
        $news = News::where('user_id', $request->user()->id)->where('status', 'active')->get();
        return $news;
    });
    Route::post('/news',[ApiNewsController::class,'store']);
    Route::put('/news/{id}',[ApiNewsController::class,'update']);
    Route::delete('/news/{id}',[ApiNewsController::class,'destroy']);
    // Route::resource('news',NewsController::class);
    Route::get('/news/search/{name}', [ApiNewsController::class, 'search']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Public Route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//Time
Route::get('/news/time/', function (Request $request) {
    // return $request->fromDate.' to '.$request->toDate;
    if ($request->fromDate != '' && $request->toDate != '') {
        $news = News::where('status', 'active')
            ->whereDate('created_at', '>=', $request->fromDate)
            ->whereDate('created_at', '<=', $request->toDate)
            ->get();
    } else {
        $news = News::where('status', 'active')
            ->get();
    }
    return $news;
});

//Author
Route::get('/news/author/{author_id}', function (Request $request) {
    return News::where('user_id', $request->author_id)->where('status', 'active')->get();
});

//Category
Route::get('/news/category/{category_id}', function (Request $request) {
    return News::where('category_id', $request->category_id)->where('status', 'active')->get();
});
