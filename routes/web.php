<?php

use Illuminate\Support\Facades\Route;

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

Route::get('mailable', function () {
    $invite = App\Model\Invite::find(9);

    return new App\Mail\Invite($invite);
});

Route::get('/','HomeController@index')->middleware(['web','auth']);

Route::get('/dashboard','HomeController@index')->name('home')->middleware(['web','auth']);

Route::get('/bicycles','BicycleController@index')->middleware(['web','locationManager']);

Auth::routes(['verify' => true]);

//Route::get('/home', 'HomeController@index')->name('home')->middleware(['web']);

Route::get('/repair','RepairController@index')->name('repair')->middleware(['web','mechanic']);
//Useless.
Route::get('/company','CompanyController@index')->name('company');

Route::get('/bicycle/timeline','BicycleController@showTimeline')->name('bicycle.timeline')->middleware(['web','mechanic']);

Route::get('/signup/{inviteCode}','SignUpController@signup')->name('signup');

Route::post('signup/{invite}/finish','SignUpController@finishSignUp')->name('axios.finish.signup');

Route::get('/users','UserController@index')->name('users')->middleware(['web','owner']);;

Route::get('/location','LocationController@showForLocationManager')->middleware(['web','auth'])->name('location');
Route::get('/location/{location}','LocationController@showLocation')->middleware(['web','auth','locationManager'])->name('location.show');

Route::get('/workplace','LocationController@showWorkplace')->name('workplace');

Route::group(['prefix' => 'axios/bicycle', 'namespace' => 'Axios\Owner'], function () {
    Route::post('/post','BicycleController@createBicycle')->name('axios.bicycle.create');
    Route::put('/{bicycle}/update','BicycleController@updateBicycle')->name('axios.bicycle.create');
    Route::delete('/{bicycle}/remove','BicycleController@deleteBicycle')->name('axios.bicycle.create');
    Route::get('/get','BicycleController@getBicycles')->name('axios.bicycle.get');
    Route::get('/paginate','BicycleController@paginateBicycles')->name('axios.bicycle.paginate');

    Route::post('/transfer','BicycleController@transferBicycle')->name('axios.bicycle.transfer');
    Route::post('/transfer-back','BicycleController@transferBicycleBack')->name('axios.bicycle.transfer-back');
});

Route::group(['prefix' => 'axios/users', 'namespace' => 'Axios\Owner'], function () {
    Route::get('/get','UserController@getUsers')->name('axios.users.get');
    Route::post('/invite','UserController@sendInvite')->name('axios.users.send.invite');
    Route::delete('{user}/delete','UserController@removeUser')->name('axios.users.delete');
});
Route::group(['prefix' => 'axios/dashboard', 'namespace' => 'Axios'], function () {
    Route::get('/location/get','DashboardController@getLocations')->name('axios.users.get');
    Route::get('/bicycle/get','DashboardController@getBicycles')->name('axios.users.get');
    Route::get('/counters/get','DashboardController@getCounters')->name('axios.counters.get');
});

Route::group(['prefix' => 'axios/bicycle', 'namespace' => 'Axios'], function () {
    Route::get('/list/get','BicycleController@getBicyclesForCustomerForRepair')->name('axios.bicycle.get.list');
});

Route::group(['prefix' => 'axios/company', 'namespace' => 'Axios\Owner'], function () {
    Route::post('/post','CompanyController@post')->name('axios.company.post');
});

Route::group(['prefix' => 'axios/bicycle', 'namespace' => 'Axios'], function () {
    Route::get('/list/get','BicycleController@getBicyclesForCustomerForRepair')->name('axios.bicycle.get.list');
    Route::get('/available/get','BicycleController@getAvailableBicycles')->name('axios.bicycle.available.get');
});
Route::group(['prefix' => 'axios/repair', 'namespace' => 'Axios'], function () {
    Route::post('/request','BicycleRepairController@requestRepair')->name('axios.bicycle.request.repair');
    Route::get('/in-repair/get','BicycleRepairController@getBicyclesInRepair')->name('axios.get.bicycles.in.repair');
    Route::post('/accept','BicycleRepairController@acceptRequest')->name('axios.get.bicycles.in.repair');
    Route::post('/bicycle/start-repair','BicycleRepairController@startRepair')->name('axios.get.start.repair');
    Route::post('/bicycle/finish-repair','BicycleRepairController@finishRepair')->name('axios.get.finish.repair');
    Route::get('/bicycles/repair-granted','BicycleRepairController@getBicyclesRepairGranted')->name('axios.bicycles.repair.granted');
    Route::get('/bicycles/repair-in-progress/get','BicycleRepairController@getBicyclesCurrentlyInRepair')->name('axios.bicycles.current.in.repair');
});
Route::group(['prefix' => 'axios/location','namespace'=> 'Axios','middleware' => ['web']], function () {
    Route::get('get','LocationController@getLocations')->name('location.show');
    Route::get('/managers/get','LocationController@getManagers')->name('location.show');
    Route::get('/{location}/get-bicycles','LocationController@getBicycles')->name('location.bicycles');
    Route::get('/all-bicycles/get','LocationController@getAllBicycles')->name('axios.location.get.all.bicycles');
    Route::post('/link','LocationController@linkLocation')->name('axios.location.link');
    Route::delete('/{location}/delete','LocationController@removeLocation')->name('axios.location.remove');
});
Route::group(['prefix' => 'axios/','namespace'=> 'Axios','middleware' => ['web']], function () {
    Route::get('/date/3-months/get','DateController@get3Months')->name('axios.3months.get');
    Route::get('/date/today/get','DateController@getToday')->name('axios.today.get');
});
