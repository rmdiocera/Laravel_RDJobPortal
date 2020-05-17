<?php

namespace App\Http\Controllers;


// use App\Providers\RouteServiceProvider;
// use App\Employer;
// use Illuminate\Foundation\Auth\RegistersUsers;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;

use App\ApplicantInfo;
use App\JobPost;
use App\JobPostApplication;
use App\EmployerInfo;
use App\Http\Requests\SaveEmployerProfile;
use App\Http\Requests\UpdateEmployerProfile;
use App\Industry;
use App\JobApplicationStatus;
use App\User;
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

    public function saveEmployerProfile(SaveEmployerProfile $request)
    {
        $validated = $request->validated();

        if (!$validated) {
            return back()->withErrors($validated)->withInput();
        }

        // $this->validate($request, [
        //     'company_name' => 'required',
        //     'industry' => 'required',
        //     'address' => 'required',
        //     'profile_picture' => 'image|nullable|max:1999',
        //     'website_link' => 'required|url',
        //     'company_size' => 'required',
        //     'benefits' => 'required',
        //     'dress_code' => 'required',
        //     'spoken_language' => 'required',
        //     'work_hours' => 'required',
        //     'avg_processing_time' => 'required',
        // ]);

        // Image Upload
        if ($request->hasFile('profile_picture')) {
            // Get original file name (on upload)
            $img_orig_filename = $request->file('profile_picture')->getClientOriginalName();
            // Get original file name without extension
            $filename = pathinfo($img_orig_filename, PATHINFO_FILENAME);
            // Get original file name extension
            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            // Filename to be stored (filename + timestamp + extension)
            $img_filename = $filename.'_'.time().'.'.$extension;
            // Upload profile picture
            $path = $request->file('profile_picture')->storeAs('public/emp_profile_pictures', $img_filename);
        } else {
            $img_filename = 'noimage.jpg';
        }

        $emp_profile = new EmployerInfo;
        $emp_profile->comp_id = Auth::user()->id;
        $emp_profile->company_name = $request->input('company_name');
        $emp_profile->company_overview = $request->input('company_overview');
        $emp_profile->industry_id = $request->input('industry');
        $emp_profile->address = $request->input('address');
        $emp_profile->profile_picture = $img_filename;
        if ($request->input('website_link')) {
            $emp_profile->website_link = $request->input('website_link');
        }
        $emp_profile->company_size = $request->input('company_size');
        $emp_profile->benefits = $request->input('benefits');
        $emp_profile->dress_code = $request->input('dress_code');
        $emp_profile->spoken_language = $request->input('spoken_language');
        $emp_profile->work_hours = $request->input('work_hours');
        $emp_profile->avg_processing_time = $request->input('avg_processing_time');
        $emp_profile->save();
        
        return redirect('/employer/show-profile')->with('success', 'Congratulations! You completed your employer profile.');
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

        if (auth()->user()->id != $comp_id) {
            return redirect('employer/show-profile')->with('warning', 'You are not authorized to view this page.');
        }

        $emp_profile = EmployerInfo::where('comp_id', $comp_id)->first();
        $industries = Industry::all();

        $data = [
            'emp_profile' => $emp_profile,
            'industries' => $industries
        ];

        return view('employers.edit_emp_profile')->with('data', $data);
    }

    public function updateEmployerProfile(UpdateEmployerProfile $request, $comp_id)
    {
        $validated = $request->validated();

        if (!$validated) {
            return back()->withErrors($validated)->withInput();
        }

        // $this->validate($request, [
        //     'company_name' => 'required',
        //     'industry' => 'required',
        //     'address' => 'required',
        //     'profile_picture' => 'image|nullable|max:1999',
        //     'website_link' => 'required|url',
        //     'company_size' => 'required',
        //     'benefits' => 'required',
        //     'dress_code' => 'required',
        //     'spoken_language' => 'required',
        //     'work_hours' => 'required',
        //     'avg_processing_time' => 'required',
        // ]);

        // Image Upload
        if ($request->hasFile('profile_picture')) {
            // Get original file name (on upload)
            $img_orig_filename = $request->file('profile_picture')->getClientOriginalName();
            // Get original file name without extension
            $filename = pathinfo($img_orig_filename, PATHINFO_FILENAME);
            // Get original file name extension
            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            // Filename to be stored (filename + timestamp + extension)
            $img_filename = $filename.'_'.time().'.'.$extension;
            // Upload profile picture
            $path = $request->file('profile_picture')->storeAs('public/emp_profile_pictures', $img_filename);
        }

        $emp_profile = EmployerInfo::where('comp_id', $comp_id)->first();
        $emp_profile->company_name = $request->input('company_name');
        $emp_profile->company_overview = $request->input('company_overview');
        $emp_profile->industry_id = $request->input('industry');
        $emp_profile->address = $request->input('address');

        if ($request->hasFile('profile_picture')) {
            $emp_profile->profile_picture = $img_filename;
        }

        $emp_profile->website_link = $request->input('website_link');
        $emp_profile->company_size = $request->input('company_size');
        $emp_profile->benefits = $request->input('benefits');
        $emp_profile->dress_code = $request->input('dress_code');
        $emp_profile->spoken_language = $request->input('spoken_language');
        $emp_profile->work_hours = $request->input('work_hours');
        $emp_profile->avg_processing_time = $request->input('avg_processing_time');
        $emp_profile->save();
        
        return redirect('/employer/show-profile')->with('success', 'Nice! You updated your employer profile.');
    }

    public function viewJobPostApplicants($job_post_id)
    {
        $job_post_applicants = DB::table('job_post_applications')
                            ->select('job_post_applications.*', 'applicant_infos.user_id as app_id', 'applicant_infos.first_name', 'applicant_infos.last_name', 'applicant_infos.resume', 'job_application_statuses.status')
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

    public function viewApplicantInfo($applicant_id)
    {
        if(request()->ajax())
        {
            $applicant_info = DB::table('applicant_infos')
                            ->select('applicant_infos.*', 'users.email', 'currencies.currency', 'degrees.degree', 'courses.course')
                            ->join('users', 'applicant_infos.user_id', '=', 'users.id')
                            ->join('currencies', 'applicant_infos.currency_id', '=', 'currencies.id')
                            ->join('degrees', 'applicant_infos.degree_id', '=', 'degrees.id')
                            ->join('courses', 'applicant_infos.course_id', '=', 'courses.id')
                            ->where('user_id', $applicant_id)
                            ->get();
            // $job_post_applicant = ApplicantInfo::where('user_id', $applicant_id)->first();
            // $applicant_email = User::where('id', $applicant_id)->pluck('email');

            return response()->json(['applicant' => $applicant_info]);
        }
    }

    public function inviteApplicantToInterview($job_post_app_id)
    {
        if(request()->ajax())
        {
            $application = JobPostApplication::find($job_post_app_id);
            $application->app_status_id = 2;
            $application->save();

            $app_status = JobApplicationStatus::where('id', $application->app_status_id)->pluck('status');

            return response()->json(['success' => 'Applicant has been invited to the interview.', 'status' => $app_status[0]]);
            // return redirect()->back()->with('success', 'Applicant has been invited to the interview.');
        }
    }

    public function rejectApplicantApplication($job_post_app_id)
    {
        if(request()->ajax())
        {
            $application = JobPostApplication::find($job_post_app_id);
            $application->app_status_id = 3;
            $application->save();
            
            $app_status = JobApplicationStatus::where('id', $application->app_status_id)->pluck('status');

            return response()->json(['success' => 'Applicant\'s application has been rejected.', 'status' => $app_status[0]]);
            // return redirect()->back()->with('success', "Applicant's application has been rejected.");
        }
    }
}
