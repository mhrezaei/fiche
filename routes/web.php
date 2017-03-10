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

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
*/

Auth::routes();
Route::get('home', 'Auth\LoginController@redirectAfterLogin');
Route::get('logout', 'Auth\LoginController@logout');

/*
|--------------------------------------------------------------------------
| Manage Side
|--------------------------------------------------------------------------
|
*/
Route::group([
	'prefix' => "manage",
	'middleware' => ['auth' , 'is:admin'],
	'namespace' => "Manage",
], function() {
	Route::get('/' , 'HomeController@index');
	Route::get('/index' , 'HomeController@index');
	Route::get('/account' , 'HomeController@account');
	Route::post('/password' , 'HomeController@changePassword');

	/*-----------------------------------------------
	| Admins ...
	*/
	Route::group(['prefix'=>'admins', 'middleware' => 'is:super'] , function() {
		Route::get('/update/{item_id}/{adding?}' , 'AdminsController@update');
		Route::get('/' , 'AdminsController@browse') ;
		Route::get('/browse/{request_tab?}' , 'AdminsController@browse') ;
		Route::get('/create/' , 'AdminsController@create') ;
		Route::get('/search' , 'AdminsController@search');
		Route::get('/{user_id}/{modal_action}' , 'AdminsController@singleAction');

		Route::group(['prefix'=>'save'] , function() {
			Route::post('/' , 'AdminsController@save');

			Route::post('/password' , 'AdminsController@password');
			Route::post('/delete' , 'AdminsController@delete');
			Route::post('/undelete' , 'AdminsController@undelete');
			Route::post('/destroy' , 'AdminsController@destroy');
			Route::post('/permits' , 'AdminsController@permits');
		});
	});


	/*-----------------------------------------------
	| Posts ...
	*/
	Route::group(['prefix'=>'posts'] , function() {
		Route::get('/update/{item_id}' , 'PostsController@update');
		Route::get('/tab_update/{posttype}/{request_tab?}/{switches?}' , 'PostsController@tabUpdate') ;

		Route::get('/check_slug/{id}/{type}/{locale}/{slug?}/p' , 'PostsController@checkSlug');
		Route::get('/act/{model_id}/{action}' , 'PostsController@singleAction');

		Route::get('/{posttype}' , 'PostsController@browse') ;
		Route::get('/{posttype}/create/{locale?}/{sisterhood?}' , 'PostsController@create');
		Route::get('{posttype}/edit/{post_id}' , 'PostsController@editor');
		Route::get('{posttype}/searched' , 'PostsController@searchResult');
		Route::get('{posttype}/search' , 'PostsController@searchPanel');
		Route::get('/{posttype}/{request_tab?}/{switches?}' , 'PostsController@browse') ;

		Route::group(['prefix'=>'save'] , function() {
			Route::post('/' , 'PostsController@save');
			Route::post('/delete' , 'PostsController@delete');
			Route::post('/undelete' , 'PostsController@undelete');
			Route::post('/destroy' , 'PostsController@destroy');
			Route::post('/clone' , 'PostsController@makeClone');
		});

	});





		/*-----------------------------------------------
		| Upstream ...
		*/
	Route::group(['prefix' => 'upstream', 'middleware' => 'is:developer'] , function() {
		Route::get('/{request_tab?}' , 'UpstreamController@index') ;
		Route::get('/{request_tab}/search/' , 'UpstreamController@search') ;
		Route::get('/edit/{request_tab?}/{item_id?}/{parent_id?}' , 'UpstreamController@editor') ;
		Route::get('/{request_tab}/{item_id}/{parent_id?}' , 'UpstreamController@item') ;

		Route::group(['prefix' => 'save'] , function() {
			Route::post('role' , 'UpstreamController@saveRole');
			Route::post('state' , 'UpstreamController@saveProvince');
			Route::post('city' , 'UpstreamController@saveCity');
			Route::post('posttype' , 'UpstreamController@savePosttype');
			Route::post('department' , 'UpstreamController@saveDepartment');
			Route::post('category' , 'UpstreamController@saveCategory');
			Route::post('downstream' , 'UpstreamController@saveDownstream');
			Route::post('downstream_value' , 'UpstreamController@setDownstream');
			Route::post('login_as' , 'UpstreamController@loginAs');
		});
	});


});


/*
|--------------------------------------------------------------------------
| Front Side
|--------------------------------------------------------------------------
|
*/

Route::group(['namespace' => 'Front', 'middleware' => ['DetectLanguage', 'Setting']], function () {
    Route::get('/', 'FrontController@index');
    Route::get('/hadi', 'TestController@index');
    Route::post('/register/new', 'FrontController@register');

    // drawing code
    Route::post('/drawing/check', 'DrawingCodeController@sumbitCode');

    Route::group(['prefix' => '{lang}', 'middleware' => ['UserIpDetect']], function () {

        Route::get('/', 'FrontController@index');
        Route::get('/products', 'ProductsController@index');
        Route::get('/products/categories/{slug}', 'ProductsController@products');
        Route::get('/page/{slug}', 'PostController@page');

        // user Route
        Route::group(['prefix' => 'user', 'middleware' => 'is:customer'], function (){
            Route::get('/dashboard', 'UserController@index');
            Route::get('/profile', 'UserController@profile');
            Route::get('/drawing', 'UserController@drawing');
        });

    });

});
