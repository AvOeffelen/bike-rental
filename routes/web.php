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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bicycles','BicycleController@index');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware(['web']);

Route::get('/repair','RepairController@index')->name('repair');
Route::get('/company','CompanyController@index')->name('company');

Route::get('/bicycle/timeline','BicycleController@showTimeline')->name('bicycle.timeline');

Route::get('/profile','UserController@showProfile')->name('profile');
Route::get('profile/edit','UserController@editProfile')->name('profile.edit')->middleware(['web']);
Route::get('/signup/continue','UserController@continueSignUp')->name('profile.continue.singup')->middleware(['web','auth']);

Route::get('/signup/{inviteCode}','SignUpController@signup')->name('signup');

Route::post('signup/{invite}/finish','SignUpController@finishSignUp')->name('axios.finish.signup');


Route::group(['prefix' => 'axios/bicycle', 'namespace' => 'Axios\Owner'], function () {
    Route::post('/post','BicycleController@createBicycle')->name('axios.bicycle.create');
    Route::put('/{bicycle}/update','BicycleController@updateBicycle')->name('axios.bicycle.create');
    Route::delete('/{bicycle}/remove','BicycleController@deleteBicycle')->name('axios.bicycle.create');
    Route::get('/get','BicycleController@getBicycles')->name('axios.bicycle.get');
    Route::get('/paginate','BicycleController@paginateBicycles')->name('axios.bicycle.paginate');
});
Route::group(['prefix' => 'axios/bicycle', 'namespace' => 'Axios'], function () {
    Route::get('/list/get','BicycleController@getBicyclesForCustomerForRepair')->name('axios.bicycle.get.list');
});

Route::group(['prefix' => 'axios/company', 'namespace' => 'Axios\Owner'], function () {
    Route::post('/post','CompanyController@post')->name('axios.company.post');
});

Route::group(['prefix' => 'axios/bicycle', 'namespace' => 'Axios'], function () {
    Route::get('/list/get','BicycleController@getBicyclesForCustomerForRepair')->name('axios.bicycle.get.list');
});
Route::group(['prefix' => 'axios/repair', 'namespace' => 'Axios'], function () {
    Route::post('/request','BicycleRepairController@requestRepair')->name('axios.bicycle.request.repair');
    Route::get('/in-repair/get','BicycleRepairController@getBicyclesInRepair')->name('axios.get.bicycles.in.repair');
});

