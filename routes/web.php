<?php

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */



/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */


Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');
Route::pattern('plots', '[0-9]+');
Route::pattern('members', '[0-9]+');
Route::pattern('pages', '[0-9a-z]+');
Route::pattern('hours', '[0-9]+');
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


Route::auth();
Route::group(['middleware'=>'auth'], function () {
//    Route::auth();
	
	Route::get('members/waitlist',['as'=>'members.waitlist','uses'=>'MembersController@waitlist']);
	Route::get('members/export',['as'=>'members.export','uses'=>'MembersController@export']);
	
	Route::resource('members','MembersController');
	

	Route::get('plotlist',array('as' => 'plotlist', 'uses' => 'PlotsController@plotlist'));
	
	Route::resource('plots','PlotsController');
	
	Route::get('hours/show/{userid}',array('as'=>'hours.show','uses'=>'HoursController@show'));
	Route::get('hours/all',array('as'=>'hours.all','uses'=>'HoursController@allhours'));
	Route::get('hours/matrix',array('as'=>'hours.matrix','uses'=>'HoursController@matrixshow'));
	Route::post('hours/matrix',array('as'=>'hours.matrix','uses'=>'HoursController@matrixadd'));
	
	Route::get('summary',['as'=>'hourssummary','uses'=>'PlotsController@getPlotHours']);
	
	Route::get('hours/plot',array('as'=>'hours.plot','uses'=>'HoursController@plothours'));
	Route::get('hours/export',array('as'=>'hours.download','uses'=>'HoursController@downloadHours'));
	Route::get('hours/multiple', array('as'=>'hours.multiple','uses'=>'HoursController@addMultipleHours'));
	Route::post('hours/multistore', array('as'=>'hours.multistore','uses'=>'HoursController@multistore'));	
	Route::resource('hours','HoursController');

	Route::get('about', function() {
		
		return response()->view('about');
	})->name('about');

	Route::get('apiseeder',['as'=>'apiseeder','uses'=>'UsersController@seeder']);

	Route::get('sms/{id}',['as'=>'smsmessage','uses'=>'SMSController@retrieveMessage']);
	
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function()
{
	
	Route::resource('forms','FormsController');	
	Route::get('manage-role', 'RoleController@manage');
	Route::resource('roles','RoleController');

	Route::resource('users','UsersController');

	Route::get('summaryemails', ['as'=>'checksummaryemails','uses'=>'PlotsController@checkSummaryEmails']);
	Route::post('summaryemails', ['as'=>'sendsummaryemails','uses'=>'PlotsController@sendSummaryEmails']);
  
 });

# Join Us Static Page
	Route::get('join', function()
	{
	   return view('pages.joinus');
	}); 

	Route::post('join', ['as'=>'join.create','uses'=>'MembersController@join']);

	Route::get('confirmation/{key}',['as'=>'join.confirmation','uses'=>'MembersController@confirm']);
	Route::get('/home', 'HomeController@index');
	/** ------------------------------------------
	 *  Frontend Routes
	 *  ------------------------------------------
	 */
	# Contact Us Static Page
	Route::get('contact_us', function()
	{
	    
	    return view('pages.contact');
	});

	Route::post('contact', array('as'=>'contact', 'uses'=>'PageController@form')); 


	Route::get('emails/hours',array('as'=>'test.hours','uses'=>'EmailController@testemail'));
	Route::get('get/emails/hours',array('as'=>'get.hours','uses'=>'EmailController@getEmail'));
	

	
	# Index Page - Last route, no matches
	Route::get('/{slug?}', ['as'=>'page.show','uses'=>'PageController@show']);

