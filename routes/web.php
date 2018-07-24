<?php

/*
|--------------------------------------------------------------------------
| Webルート
|--------------------------------------------------------------------------
|
| ここでアプリケーションのWebルートを登録できます。"web"ルートは
| ミドルウェアのグループの中へ、RouteServiceProviderによりロード
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [
    'as' => 'index',
    'uses' => 'TransactionController@index'
]);
// 入力バリデーション
Route::post('input/validate/{token}', [
    'as' => 'validate_input',
    'uses' => 'TransactionController@validateInput'
]);
// 確認画面表示
Route::get('input/confirm/{token}', [
    'as' => 'confirm',
    'uses' => 'TransactionController@confirm'
]);
// データ登録
Route::post('input/register/{token}', [
    'as' => 'register',
    'uses' => 'TransactionController@register'
]);
// 完了画面表示
Route::get('input/complete', [
    'as' => 'complete',
    'uses' => 'TransactionController@complete'
]);
// 入力画面表示
Route::get('input/{token?}', [
    'as' => 'input',
    'uses' => 'TransactionController@input'
]);
