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
//Route::post('clientProfileCreate', [
//    'uses' => 'ClientsController@store'
//]);


//Routingi do operacji create/update
Route::post('clientProfileUpdate/{id}', ['uses' => 'ClientsController@update']);
Route::post('createActivity', ['uses' => 'Clients_GroupActivitiesController@create']);
Route::post('createTicket', ['uses' => 'TicketsController@create']);
Route::post('getPersonalTraining', ['uses' => 'PersonalTrainingController@create']);
Route::post('deleteActivity/{id}', ['uses' => 'Clients_GroupActivitiesController@destroy']);

Route::get('/', 'PagesController@index');
Route::get('/tickets', 'PagesController@tickets');
Route::get('/clientUpdate', 'ClientsController@clientUpdate');
Route::get('/clientActivity', 'ClientsController@clientActivity');
Route::get('/groupActivities', 'GroupsActivityController@index');
Route::get('/personalTraining', 'PagesController@personalTraining');
Route::get('/contact', 'PagesController@contact');

//Route::resource('tickets', 'TicketsController');
//Route::resource('userInfo', 'UsersController');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'AdminController@index')->name('admin')->middleware('admin');
Route::get('/client', 'ClientsController@index')->name('clients')->middleware('clients');
Route::get('/trainer', 'TrainersController@index')->name('trainers')->middleware('trainers');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
