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

Auth::routes(['register' => false]);



Route::get('/', 'HomeController@login');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/show', 'HomeController@show')->name('user-show');
Route::get('/user', 'HomeController@userlisting');

Route::get('/user/edit/{id}','HomeController@edituser')->name('edit-user');
Route::post('update-user/{id}','HomeController@update')->name('update-user');
Route::get('show-user/{id}','HomeController@showUser')->name('show-user');

Route::get('delete/{id?}','HomeController@delete')->name('delete-user');

// Admin update Profile
Route::get('admin/','AdminController@edit')->name('admin-profile');
Route::post('admin/update','AdminController@update')->name('admin-update');

// Admin Approve and reject routes
Route::get('approve/{id}', 'AdminController@approve')->name('admin.approve');
Route::get('decline/{id}', 'AdminController@decline')->name('admin.decline');
// Moderator routes
Route::resource('moderator', 'ModeratorController');
Route::get('moderator/destroy/{id}','ModeratorController@destroy');
// Events Routes
Route::resource('events', 'EventsController');
Route::get('events/destroy/{id}', 'EventsController@destroy');

// Report routes

Route::get('reports','kikiReportsController@index')->name('reports.index');
Route::delete('reports/destroy/{id}','kikiReportsController@destroy')->name('reports.destroy');

// User Reporting

Route::get('user/report','ReportsController@index')->name('user.reports');
Route::delete('report/delete/{id}','ReportsController@destroy')->name('userreports.destroy');


// Matches Routes

Route::get('user/matches','MatchesController@index')->name('user.matches');
Route::delete('delete/matches/{id}','MatchesController@destroy')->name('match.destroy');

// Route Privacypolicy routes

Route::get('privacy','privacyController@create')->name('privacy.create');
Route::post('privacy/store/{id}','PrivacyController@store')->name('privacy.store');

//terms and conditions routes

Route::get('terms','TermController@create')->name('terms.create');
Route::post('term/store/{id}','TermController@store')->name('terms.store');

// Categories routes

Route::resource('category', 'CategoryController');

// Admin setting routes

Route::get('category','AdminSettingController@index')->name('category-create'); 
Route::post('add/category','AdminSettingController@saveCategory')->name('save-category');

// Value routes
Route::get('value','AdminSettingController@addvalue')->name('value.create');
Route::post('add/value','AdminSettingController@add')->name('value.add');
Route::get('populate','AdminSettingController@getValuePopulate');

//kiki post

Route::resource('kiki/Post', 'kikiPostController');

Route::post('add/value','AdminSettingController@add')->name('value.add');


//Console Command Test Route
Route::get('check_user', 'AdminController@checkUsers');







