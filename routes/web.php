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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/Register', function () {
//     return view('welcome');
// })->name('login');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::post('/token_request', 'TokenController@requestToken')->name('requestToken');
Route::get('/course', 'CourseController@index')->name('course.home');
Route::get('/course/create', 'CourseController@create')->name('course.create');
Route::post('/course/save', 'CourseController@store')->name('course.save');
Route::get('/course/{bid}', 'CourseController@show')->name('course.show');
Route::post('/course/delete/{bid}', 'CourseController@delete')->name('course.delete');
Route::get('/course/edit/{bid}', 'CourseController@edit')->name('course.edit');
Route::put('/course/update/{bid}', 'CourseController@update')->name('course.update');



//api routes...
Route::group(['prefix'=>'api','namespace'=>'CourseApi','middleware'=>[]], function () {
    Route::get('/course', 'CourseApiController@index');
    Route::get('/course/show', 'CourseApiController@show')->name('courseApi.show');
    Route::get('/course/save', 'CourseApiController@store')->name('courseApi.store');
    Route::get('/course/update', 'CourseApiController@update')->name('courseApi.update');
    Route::get('/course/delete/{course}', 'CourseApiController@destroy')->name('courseApi.delete');
});
