<?php
use App\Notifications\HoursAdded;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'web'], function () {
    Route::auth();
	
	Route::get('members/waitlist',['as'=>'members.waitlist','uses'=>'MembersController@waitlist']);
	Route::get('members/export',['as'=>'members.export','uses'=>'MembersController@export']);
	Route::get('members/{members}/delete',['as'=>'member.delete','uses'=>'MembersController@destroy']);
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
	Route::get('hours/{id}/delete', ['as'=>'hours.delete','uses'=>'HoursController@destroy']);	
	Route::resource('hours','HoursController');
	
	


	Route::get('manage-role', 'RoleController@manage');
	Route::resource('roles','RoleController');

	Route::get('testuser',function(){
		dd(Auth::user()->getUsersPlot());
	});
});


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


Route::get('api/hours',array('as'=>'api.hours','uses'=>'EmailController@testemail'));
Route::post('api/hours',array('as'=>'api.hours','uses'=>'HoursController@receiveHoursEmail'));


# Join Us Static Page
Route::get('join', function()
{
    // Return contact us page
    return view('pages.joinus');
}); 

Route::get('privacy',['as'=>'privacy'], function()
	{
		return view('pages.privacy');
	});

//Route::post('join', array('as'=>'join', 'uses'=>'AdminUsersController@join'));


# Index Page - Last route, no matches
Route::get('/', function()
	{
		return view('site.pages.frontpage');
	});

