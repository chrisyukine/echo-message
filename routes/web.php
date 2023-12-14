<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('wechat')->group(function () {
    Route::post('/work_send_msg', 'WxWorkMsgController@sendMsg'); //发送微信信息

    //任务抓取与推送
    Route::prefix('daily_push')->group(function () {
        Route::get('/diff_message', 'DailyPushController@dailyDiffMessage');        //每日信息差
    });
});
