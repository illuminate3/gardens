<?php
/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('hours', 'Hours');
Route::model('role', 'Role');
Route::model('plots', 'Plot');
Route::model('members', 'Member');



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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'web'], function () {
    Route::auth();
	
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
	
	


	Route::get('manage-role', 'RoleController@manage');
	Route::resource('roles','RoleController');
});


Route::get('/home', 'HomeController@index');
/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */
# Contact Us Static Page
Route::get('contact_us', function()
{
    
    return View::make('pages.contact');
});

Route::post('contact', array('as'=>'contact', 'uses'=>'PagesController@form')); 



Route::get('pages','PagesController@index');
Route::get('pages/{slug}','PagesController@show');

Route::get('api/hours',array('as'=>'api.hours','uses'=>'EmailController@testemail'));
Route::post('api/hours',array('as'=>'api.hours','uses'=>'HoursController@receiveHoursEmail'));


# Join Us Static Page
Route::get('join', function()
{
    // Return contact us page
    return View::make('pages.joinus');
});

Route::get('privacy', array('as'=>'privacy','uses'=>'PagesController@privacy'));

Route::post('join', array('as'=>'join', 'uses'=>'AdminUsersController@join'));

Route::post('news', array('as'=>'news', 'uses'=>'NewslettersController@store'));

# Pages - Second to last set, match slug
Route::resource('pages','PagesController',array('only' => array('show')));

# Index Page - Last route, no matches
Route::get('/', array('before' => 'detectLang','uses' => 'PageController@getIndex'));

