<?php

use Illuminate\Support\Facades\Route;
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

Auth::routes(['verify'=>true]);





Route::group(['middleware' => ['auth', 'verified']],function (){
    Route::group(['middleware' => ['role:superAdmin']], function () {
        Route::post('/admin/newAdmin','AdminController@newAdmin');
        Route::post('/admin/newChannel','AdminController@newChannel');
        Route::get('/admin/channels/{channel}/delete','AdminController@deleteChannel');
        Route::get('/admin/sections/{section}/delete','AdminController@deleteSection');
        Route::post('/admin/process/{candidate}','CandidateController@process');
        Route::get('/admin/{user}/{permission}/downgrade','AdminController@downgrade');
        Route::post('/admin/newSection','AdminController@newSection');

    });
    Route::group(['middleware' => ['role:superAdmin|admin']], function () {
        Route::get('/admin/dashboard','AdminController@dashboard');
    });
    Route::group(['middleware' => ['role:admin']], function () {
        Route::put('/admin/markAsResolved/{report}','ReportController@delete');
    });
    Route::group(['middleware'=>['subscription']],function(){
        Route::post('/candidate/{channel}/{channelId}','CandidateController@store');

        Route::get('/channels/{channel}','ChannelController@index');

        Route::post('/post/{channel}','PostController@create');
        Route::post('/{channel}/reply/{comment}','ReplyController@create');
        Route::get('/{channel}/posts/like/{post}','PostController@like');
        Route::get('/{channel}/replies/like/{reply}','ReplyController@like');
        Route::get('/{channel}/delete/posts/{post}','PostController@delete');
        Route::get('/{channel}/delete/replies/{reply}','ReplyController@delete');
        Route::get('/{channel}/posts/pin/{post}','PostController@pin');
        Route::get('/{channel}/{section}/threads','SectionController@index');
        Route::get('/{channel}/{section}/createThread','ThreadController@create');
        Route::get('/{channel}/{section}/threads/{thread}','ThreadController@show');
        Route::post('/store/{channel}/{section}/createThread','ThreadController@store');
        Route::post('/{channel}/threads/solve/{thread}','SolutionController@store');
        Route::get('/{channel}/solutions/delete/{solution}','SolutionController@delete');
        Route::get('/{channel}/threads/delete/{thread}','ThreadController@delete');
        Route::get('/{channel}/{thread}/edit','ThreadController@edit');
        Route::get('/{channel}/{solution}/isBest','SolutionController@best');
        Route::put('/{channel}/threads/{thread}','ThreadController@update');
        Route::get('/{channel}/delete/solutions/{solution}','SolutionController@delete');
        Route::get('/{channel}/comments/like/{comment}','CommentController@like');
        Route::post('/{channel}/report/{table}/{model}','ReportController@create');
        Route::get('/{channel}/delete/{table}/{comment}','CommentController@delete');
        Route::post('/{channel}/comment/{table}/{model}','CommentController@create');


    });
    Route::get('/channels','ChannelController@list');
    Route::post('/{channel}/subscribe','UserController@subscribe');
    Route::post('/{channel}/unsubscribe','UserController@unsubscribe');







    Route::get('/{user}/profile','UserController@show');
    Route::put('/{user}/resetEmail','UserController@reset');
    Route::post('/{user}/image','UserController@image');
    Route::get('/confirm/delete','UserController@delete')->middleware('password.confirm');


});
