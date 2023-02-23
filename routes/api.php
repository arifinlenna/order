<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
route publish rabbitmq sending in queue test
*/
Route::get('testapi', 'orderController@index')->name('testapi');

/*
route consuming rabbitmq when data ready in queue test
*/
Route::get('notification', 'orderController@notification')->name('notification');

/*
testing from routes straight to send-email
*/
Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('arifingdr@gmail.com')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});
