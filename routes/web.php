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

//admin routes
Route::middleware('admin:accessAdmin')->group(function() {
    Route::get('/usersList', 'AdminController@usersList');
    Route::get('/ticketsList', 'AdminController@ticketsList');
    Route::get('/activitiesList', 'AdminController@activitiesList');
    Route::get('/trainersList', 'AdminController@trainersList');
    Route::get('/updateUserForm/{id}', 'AdminController@updateUserForm');
    Route::get('/deleteUser/{id}', 'AdminController@deleteUser');
    Route::get('/addUserForm', 'AdminController@addUserForm');
    Route::get('/deleteActivity/{id}', 'AdminController@deleteActivity');
    Route::get('/addActivityForm', 'AdminController@addActivityForm');
    Route::get('/updateActivityForm/{id}', 'AdminController@updateActivityForm');
    Route::get('/updateTrainerForm/{id}', 'AdminController@updateTrainerForm');
    Route::get('/deleteTrainer/{id}', 'AdminController@deleteTrainer');
    Route::get('/addTrainerForm', 'AdminController@addTrainerForm');

    Route::post('createUser', ['uses' => 'AdminController@createUser']);
    Route::post('updateUser/{id_c}/{id_u}', ['uses' => 'AdminController@updateUser']);
    Route::post('createTrainer', ['uses' => 'AdminController@createTrainer']);
    Route::post('updateTrainer/{id_t}/{id_u}', ['uses' => 'AdminController@updateTrainer']);
    Route::post('createActivity', ['uses' => 'AdminController@createActivity']);
    Route::post('updateActivity/{id}', ['uses' => 'AdminController@updateActivity']);
});

//clients routes
Route::middleware('clients:accessClients')->group(function() {
    Route::post('clientProfileUpdate/{id}', ['uses' => 'ClientsController@update']);
    Route::post('joinActivity', ['uses' => 'Clients_GroupActivitiesController@create']);
    Route::post('createTicket', ['uses' => 'TicketsController@create']);
    Route::post('getPersonalTraining', ['uses' => 'PersonalTrainingController@create']);
    Route::post('deleteActivity/{id}', ['uses' => 'Clients_GroupActivitiesController@deleteUserActivity']);
    Route::post('deletePersonalTraining/{id}', ['uses' => 'PersonalTrainingController@deleteUserPersonalTraining']);

    Route::get('/clientUpdate/{id}', 'ClientsController@clientUpdate');
    Route::get('/clientActivity', 'ClientsController@clientActivity');
    Route::get('/groupActivities', 'GroupsActivityController@index');
});

//trainers routes
Route::middleware('trainers:accessTrainers')->group(function() {
    Route::get('/updatePersonalTrainerForm/{id}', 'TrainersController@updatePersonalTrainerForm');
    Route::post('updatePersonalTrainer/{id_t}/{id_u}', ['uses' => 'TrainersController@updatePersonalTrainer']);
    Route::get('/trainerActivity', 'TrainersController@trainerActivity');
});

//pages routes
Route::get('/', 'PagesController@index');
Route::get('/tickets', 'PagesController@tickets');
Route::get('/personalTraining', 'PagesController@personalTraining');
Route::get('/contact', 'PagesController@contact');

// typy kont i logout routes
Auth::routes();
Route::get('/admin', 'AdminController@index')->name('admin')->middleware('admin');
Route::get('/client', 'ClientsController@index')->name('clients')->middleware('clients');
Route::get('/trainer', 'TrainersController@index')->name('trainers')->middleware('trainers');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
