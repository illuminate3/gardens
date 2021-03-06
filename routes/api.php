<?php

use Illuminate\Http\Request;

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


Route::post('emails/hours',array('as'=>'api.hours','uses'=>'EmailController@receiveHoursEmail'))->middleware('api');

Route::get('sms/hours',array('as'=>'api.hours','uses'=>'SMSController@receiveHoursSMS'));
