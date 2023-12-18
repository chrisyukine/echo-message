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
    Route::post('work_send_msg', 'WxWorkMsgController@sendMsg'); //发送微信信息
});

Route::prefix('diff_msg')->group(function () {
    //任务抓取与推送
    Route::prefix('toutiao')->group(function () {
        Route::get('yeshifu', 'DailyPushController@toutiaoDiffMessage');
        Route::get('xintiaohuiyi', 'DailyPushController@toutiaoDiffMessageDaily');
    });
});
