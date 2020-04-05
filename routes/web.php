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
// Basic Pages
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/contact-us', 'PagesController@contact_us');

// Job Posts
Route::get('/job-search', 'JobPostsController@index');
Route::get('/job-post/{id}', 'JobPostsController@show');
Route::get('/create-job-post', 'JobPostsController@create');
Route::post('/job-search', 'JobPostsController@store');
Route::get('/job-post/{id}/edit', 'JobPostsController@edit');
Route::put('/job-post/{id}', 'JobPostsController@update');
Route::delete('/destroy/{id}', 'JobPostsController@destroy');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

// Employers
Route::prefix('employer')->group(function()
{
    Route::get('/login', 'Auth\EmployerLoginController@showLoginForm')->name('employer.login');
    Route::post('login', 'Auth\EmployerLoginController@login')->name('employer.login.submit');
    Route::get('/register', 'Auth\EmployerRegisterController@showRegistrationForm')->name('employer.register');
    Route::post('register', 'Auth\EmployerRegisterController@register')->name('employer.register.submit');
    Route::get('/', 'EmployersController@index')->name('employer.dashboard');
    Route::post('/logout', 'Auth\EmployerLoginController@logout')->name('employer.logout');
});
