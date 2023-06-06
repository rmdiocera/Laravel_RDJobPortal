<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
Route::get('/', 'PagesController@index')->name('site.main');
// Route::get('/test', function(){
//     return view('pages.test');
// });
Route::get('/about', 'PagesController@about')->name('site.about_us');
Route::get('/contact-us', 'PagesController@contactUs')->name('site.contact_us');
Route::get('/job-search', 'PagesController@showJobPosts')->name('site.job_search');
Route::get('/job-post/{id}', 'PagesController@showJobPost');
Route::get('/company/{id}', 'PagesController@viewCompanyProfile')->name('site.company_profile');
// Route::get('/emp-info/{id}', 'PagesController@viewCompanyProfile');

// Job Posts
Route::get('/job-posts', 'JobPostsController@index')->name('employer.job_posts');
Route::get('/create-job-post', 'JobPostsController@create');
Route::post('/job-search', 'JobPostsController@store');
Route::get('/job-post/{id}/edit', 'JobPostsController@edit');
Route::put('/job-post/{id}', 'JobPostsController@update');
Route::delete('/destroy/{id}', 'JobPostsController@destroy');

Route::get('/job-post/{id}/view', 'EmployersController@viewJobPostApplicants');
// Route::get('/app-info/{id}', 'EmployersController@viewApplicantInfo');
Route::get('/applicant/{id}', 'EmployersController@viewApplicantInfo');
Route::put('/invite/{id}', 'EmployersController@inviteApplicantToInterview');
Route::put('/reject/{id}', 'EmployersController@rejectApplicantApplication');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('user.dashboard');
Route::get('/home/create-profile', 'HomeController@showCreateApplicantProfile')->name('user.create_profile');
Route::get('/home/create-profile-redirect/', 'HomeController@redirectToCreateApplicantProfile')->name('user.redirect_to_create_profile');
Route::post('/create-profile', 'HomeController@saveApplicantProfile')->name('user.create_profile.submit');
Route::get('/home/show-profile', 'HomeController@showApplicantProfile')->name('user.show_profile');
Route::get('/home/{id}/edit', 'HomeController@editApplicantProfile')->name('user.edit_profile');
Route::put('/update/{id}', 'HomeController@updateApplicantProfile')->name('user.update_profile');
Route::post('/apply-to-job-post', 'HomeController@storeApplicantJobPostApplication')->name('user.apply_to_job_post');
Route::get('active-applications', 'HomeController@showActiveApplications')->name('user.show_saved_job_posts');
Route::put('/accept/{id}', 'HomeController@acceptInterviewInvitation');
Route::put('/decline/{id}', 'HomeController@declineInterviewInvitation');
Route::delete('/job-post/{id}/withdraw', 'HomeController@removeApplicantJobPostApplication')->name('user.withdraw_application');
Route::post('/save-job-post', 'HomeController@saveJobPost')->name('user.save_job_post');
Route::delete('/job-post/{id}/unsave', 'HomeController@unsaveJobPost')->name('user.unsave_job_post');
Route::get('saved-job-posts', 'HomeController@showSavedJobPosts')->name('user.show_saved_job_posts');
Route::post('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

// Employers
Route::prefix('employer')->group(function()
{
    Route::get('/login', 'Auth\EmployerLoginController@showLoginForm')->name('employer.login');
    Route::post('login', 'Auth\EmployerLoginController@login')->name('employer.login.submit');
    Route::get('/register', 'Auth\EmployerRegisterController@showRegistrationForm')->name('employer.register');
    Route::post('register', 'Auth\EmployerRegisterController@register')->name('employer.register.submit');
    Route::get('/', 'EmployersController@index')->name('employer.dashboard');
    Route::get('/job-post/{id}', 'JobPostsController@show')->name('job_post');
    Route::get('/create-profile', 'EmployersController@showCreateEmployerProfile')->name('employer.create_profile');
    Route::post('/create-profile', 'EmployersController@saveEmployerProfile')->name('employer.create_profile.submit');
    Route::get('/show-profile', 'EmployersController@showEmployerProfile')->name('employer.show_profile');
    Route::get('/{id}/edit', 'EmployersController@editEmployerProfile')->name('employer.edit_profile');
    Route::put('/update/{cid}', 'EmployersController@updateEmployerProfile')->name('employer.update_profile');
    Route::get('/', 'EmployersController@index')->name('employer.dashboard');
    Route::post('/logout', 'Auth\EmployerLoginController@logout')->name('employer.logout');
});

// Fallback Route
Route::fallback(function() {
    abort(404);
});