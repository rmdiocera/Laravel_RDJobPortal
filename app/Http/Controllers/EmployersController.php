<?php

namespace App\Http\Controllers;


// use App\Providers\RouteServiceProvider;
// use App\Employer;
// use Illuminate\Foundation\Auth\RegistersUsers;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;

use App\JobPost;
use App\JobPostApplication;
use App\EmployerInfo;
use App\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!EmployerInfo::where('comp_id', Auth::user()->id)->first()) {
            return redirect(route('employer.create_profile'));
        }

        return view('employers.home');
    }

    public function showCreateEmployerProfile()
    {
        if (EmployerInfo::where('comp_id', Auth::user()->id)->first()) {
            return redirect(route('employer.dashboard'));
        }

        $industries = Industry::all();

        return view('profile.create_emp_profile')->with('industries', $industries);
    }

    public function saveEmployerProfile(Request $request)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'industry' => 'required',
            'address' => 'required',
            'website_link' => 'required|url',
            'company_size' => 'required',
            'benefits' => 'required',
            'dress_code' => 'required',
            'spoken_language' => 'required',
            'work_hours' => 'required',
            'avg_processing_time' => 'required',
        ]);

        $emp_profile = new EmployerInfo;
        $emp_profile->comp_id = Auth::user()->id;
        $emp_profile->company_name = $request->input('company_name');
        $emp_profile->industry_id = $request->input('industry');
        $emp_profile->address = $request->input('address');
        $emp_profile->website_link = $request->input('website_link');
        $emp_profile->company_size = $request->input('company_size');
        $emp_profile->benefits = $request->input('benefits');
        $emp_profile->dress_code = $request->input('dress_code');
        $emp_profile->spoken_language = $request->input('spoken_language');
        $emp_profile->work_hours = $request->input('work_hours');
        $emp_profile->avg_processing_time = $request->input('avg_processing_time');
        $emp_profile->save();
        
        return redirect('/employer')->with('success', 'Congratulations! You completed your employer profile.');
    }

    public function showEmployerProfile()
    {
        if (!EmployerInfo::where('comp_id', Auth::user()->id)->first()) {
            return redirect(route('employer.create_profile'));
        }

        $emp_profile = DB::table('employer_infos')
                        ->select('employer_infos.*', 'industries.industry')
                        ->join('industries', 'employer_infos.industry_id', '=', 'industries.id')
                        ->where('comp_id', Auth::id())
                        ->get();
        
        return view('employers.employer_profile')->with('profile', $emp_profile);
    }

    public function editEmployerProfile($comp_id)
    {
        if (!EmployerInfo::where('comp_id', Auth::user()->id)->first()) {
            return redirect(route('employer.create_profile'));
        }

        $emp_profile = EmployerInfo::where('comp_id', $comp_id)->first();
        $industries = Industry::all();

        $data = [
            'emp_profile' => $emp_profile,
            'industries' => $industries
        ];

        return view('employers.edit_emp_profile')->with('data', $data);
    }

    public function updateEmployerProfile(Request $request, $comp_id)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'industry' => 'required',
            'address' => 'required',
            'website_link' => 'required|url',
            'company_size' => 'required',
            'benefits' => 'required',
            'dress_code' => 'required',
            'spoken_language' => 'required',
            'work_hours' => 'required',
            'avg_processing_time' => 'required',
        ]);

        $emp_profile = EmployerInfo::where('comp_id', $comp_id)->first();
        $emp_profile->company_name = $request->input('company_name');
        $emp_profile->industry_id = $request->input('industry');
        $emp_profile->address = $request->input('address');
        $emp_profile->website_link = $request->input('website_link');
        $emp_profile->company_size = $request->input('company_size');
        $emp_profile->benefits = $request->input('benefits');
        $emp_profile->dress_code = $request->input('dress_code');
        $emp_profile->spoken_language = $request->input('spoken_language');
        $emp_profile->work_hours = $request->input('work_hours');
        $emp_profile->avg_processing_time = $request->input('avg_processing_time');
        $emp_profile->save();
        
        return redirect('/employer')->with('success', 'Nice! You updated your employer profile.');
    }

    public function viewJobPostApplicants($job_post_id)
    {
        $job_post_applicants = DB::table('job_post_applications')
                            ->select('job_post_applications.*', 'applicant_infos.first_name', 'applicant_infos.last_name', 'job_application_statuses.status')
                            ->join('applicant_infos', 'job_post_applications.user_id', '=', 'applicant_infos.user_id')
                            ->join('job_application_statuses', 'job_post_applications.app_status_id', '=', 'job_application_statuses.id')
                            ->where('job_post_id', $job_post_id)
                            ->orderBy('created_at', 'asc')
                            ->get();

        $job_post = JobPost::where('id', $job_post_id)->first();

        // return $job_post_applicants;
        return view('employers.view_job_post_applicants')->with('applicants', $job_post_applicants)
                                                         ->with('job_post', $job_post);
    }

    public function inviteApplicantToInterview($job_post_app_id)
    {
        $application = JobPostApplication::find($job_post_app_id);
        $application->app_status_id = 2;
        $application->save();
        
        return redirect()->back()->with('success', 'Applicant has been invited to the interview.');
    }

    public function rejectApplicantApplication($job_post_app_id)
    {
        $application = JobPostApplication::find($job_post_app_id);
        $application->app_status_id = 3;
        $application->save();
        
        return redirect()->back()->with('success', "Applicant's application has been rejected.");
    }
}
