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

// automatic add api prefix
Route::group(['namespace' => 'Api'], function (){
    Route::get('/', 'ApiController@index');
    Route::post('ehda/getToken', 'ApiController@get_token');
    Route::post('/ehda/card/search', 'ApiController@ehda_card_search');
    Route::post('/ehda/card/register', 'ApiController@ehda_card_register');
    Route::post('/ehda/card/get', 'ApiController@get_card');
    Route::post('/ehda/province/get', 'ApiController@get_province');
    Route::post('/ehda/cities/get', 'ApiController@get_cities');
    Route::post('/ehda/education/get', 'ApiController@get_education');
});
