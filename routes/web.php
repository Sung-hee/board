<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

Route::middleware('auth')->prefix('article')->group(function() {
    //인덱스 리스트
    Route::get('/', 'ArticleController@index')->name('article.index');
    //글쓰기 폼
    Route::get('/create', 'ArticleController@create')->name('article.create');
    //새로운글 저장
    Route::post('/', 'ArticleController@store')->name('article.store');
    //해당글 보기 
    Route::get('/{article}', 'ArticleController@show')->name('article.show');
    //해당글 수정 폼
    Route::get('/{article}/edit', 'ArticleController@edit')->name('article.edit');
    //해당글 업데이트
    Route::put('/{article}', 'ArticleController@update')->name('article.update');
    //해당글 삭제
    Route::delete('/{article}/destroy', 'ArticleController@destroy')->name('article.destroy');
});

Route::get('/auth/email-authenticate/{token}', 'Auth\LoginController@authenticateEmail')->name('auth.email-authenticate');

Route::post('/comments/store', 'CommentController@store')->name('comment.add');