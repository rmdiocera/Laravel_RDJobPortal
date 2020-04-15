<?php

namespace App\Http\Controllers;

use App\ApplicantInfo;
use App\Country;
use App\Course;
use App\Currency;
use App\Degree;
use App\Gender;
use App\Nationality;
use App\SavedJobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'));
        }

        return view('home');
    }

    public function showCreateApplicantProfile()
    {
        if (ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.dashboard'));
        }

        $genders = Gender::all();
        $countries = Country::all();
        $nationalities = Nationality::all();
        $currencies = Currency::all();
        $degrees = Degree::all();
        $courses = Course::all();

        $data = [
            'genders' => $genders,
            'nationalities' => $nationalities,
            'countries' => $countries,
            'currencies' => $currencies,
            'degrees' => $degrees,
            'courses' => $courses
        ];

        return view('profile.create_app_profile')->with('data', $data);
    }

    public function saveApplicantProfile(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'country' => 'required',
            'nationality' => 'required',
            'mobile_phone_no' => array(
                'required',
                'unique:applicant_infos',
                'size: 11',
                'regex:/^(?!(?:09[0][1-4]|[8][34678]|[9][01])[0-9]{7}$)\d+/'
            ),
            'job_title' => 'required',
            'company_name' => 'required',
            'start_date' => 'required',
            'currency' => 'required',
            'salary' => 'required',
            'tasks' => 'required',
            'university' => 'required',
            'degree' => 'required',
            'course' => 'required',
            'univ_start_date' => 'required',
            'univ_end_date' => 'required',
        ]);

        $gender = Gender::find($request->input('gender'));
        $country = Country::find($request->input('country'));
        $nationality = Nationality::find($request->input('nationality'));
        $currency = Currency::find($request->input('currency'));
        $degree = Degree::find($request->input('degree'));
        $course = Course::find($request->input('course'));

        $app_profile = new ApplicantInfo;
        $app_profile->user_id = Auth::user()->id;
        $app_profile->first_name = $request->input('first_name');
        $app_profile->last_name = $request->input('last_name');
        $app_profile->age = $request->input('age');
        $app_profile->gender = $gender->gender;
        $app_profile->address = $request->input('address');
        $app_profile->country = $country->country_name;
        $app_profile->nationality = $nationality->nationality;
        $app_profile->mobile_phone_no = $request->input('mobile_phone_no');
        $app_profile->job_title = $request->input('job_title');
        $app_profile->company_name = $request->input('company_name');
        $app_profile->start_date = $request->input('start_date');
        
        if($request->input('end_date')) {
            $app_profile->end_date = $request->input('end_date');
        }

        $app_profile->salary = $currency->currency." ".$request->input('salary');
        $app_profile->tasks = $request->input('tasks');
        $app_profile->university = $request->input('university');
        $app_profile->degree = $degree->degree;
        $app_profile->course = $course->course;
        $app_profile->univ_start_date = $request->input('univ_start_date');
        $app_profile->univ_end_date = $request->input('univ_end_date');
        $app_profile->save();
        
        return redirect('/home')->with('success', 'Congratulations! You completed your employer profile.');
    }

    public function showApplicantProfile()
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'));
        }

        $app_profile = ApplicantInfo::where('user_id', Auth::user()->id)->first();
        $country_code = Country::where('country_name', $app_profile->country)->first();

        return view('applicant_profile')->with('profile', $app_profile)
                                        ->with('country_code', $country_code);
    }

    public function saveJobPost($job_post_id)
    {
        // Check if user logged in

        // Check if job post already saved in saved_job_posts db

        // Save to db
        $saved_job_post = new SavedJobPost;
        $saved_job_post->user_id = Auth::id();
        $saved_job_post->job_post_id = $job_post_id;
        $saved_job_post->save();

        return redirect('/job-search')->with('success', 'The job post has been saved.');
    }
}
