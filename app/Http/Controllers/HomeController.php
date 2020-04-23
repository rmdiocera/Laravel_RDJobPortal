<?php

namespace App\Http\Controllers;

use App\ApplicantInfo;
use App\Country;
use App\Course;
use App\Currency;
use App\Degree;
use App\Gender;
use App\JobPostApplication;
use App\Nationality;
use App\SavedJobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                'unique:applicant_infos,mobile_phone_no',
                'size: 11',
                'regex:/^(?!(?:09[0][1-4]|[8][34678]|[9][01])[0-9]{7}$)\d+/'
            ),
            'profile_picture' => 'image|nullable|max:1999',
            'resume' => 'mimes:pdf|nullable|max:2048',
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
            $path = $request->file('profile_picture')->storeAs('public/app_profile_pictures', $img_filename);
        } else {
            $img_filename = 'noimage.jpg';
        }

        if ($request->hasFile('resume')) {
            // Get original file name (on upload)
            $pdf_orig_filename = $request->file('resume')->getClientOriginalName();
            // Get original file name without extension
            $filename_pdf = pathinfo($pdf_orig_filename, PATHINFO_FILENAME);
            // Get original file name extension
            $extension_pdf = $request->file('resume')->getClientOriginalExtension();
            // Filename to be stored (filename + timestamp + extension)
            $pdf_filename = $filename_pdf.'_'.time().'.'.$extension_pdf;
            // Upload profile picture
            $path_pdf = $request->file('resume')->storeAs('public/app_resume', $pdf_filename);
        }

        $app_profile = new ApplicantInfo;
        $app_profile->user_id = Auth::user()->id;
        $app_profile->first_name = $request->input('first_name');
        $app_profile->last_name = $request->input('last_name');
        $app_profile->age = $request->input('age');
        $app_profile->gender_id = $request->input('gender');
        $app_profile->address = $request->input('address');
        $app_profile->country_id = $request->input('country');
        $app_profile->nationality_id = $request->input('nationality');
        $app_profile->mobile_phone_no = $request->input('mobile_phone_no');
        $app_profile->profile_picture = $img_filename;
        $app_profile->resume = $pdf_filename;
        $app_profile->job_title = $request->input('job_title');
        $app_profile->company_name = $request->input('company_name');
        $app_profile->start_date = $request->input('start_date');
        
        if($request->input('end_date')) {
            $app_profile->end_date = $request->input('end_date');
        }

        $app_profile->currency_id = $request->input('currency');
        $app_profile->salary = $request->input('salary');
        $app_profile->tasks = $request->input('tasks');
        $app_profile->university = $request->input('university');
        $app_profile->degree_id = $request->input('degree');
        $app_profile->course_id = $request->input('course');
        $app_profile->univ_start_date = $request->input('univ_start_date');
        $app_profile->univ_end_date = $request->input('univ_end_date');
        $app_profile->save();
        
        // return $app_profile;
        return redirect('/home')->with('success', 'Congratulations! You completed your profile.');
    }

    public function showApplicantProfile()
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'));
        }

        $app_profile = DB::table('applicant_infos')
                        ->select('applicant_infos.*', 'genders.gender', 'countries.country_code', 'countries.country_name', 'nationalities.nationality', 'currencies.currency', 'degrees.degree', 'courses.course')
                        ->join('genders', 'applicant_infos.gender_id', '=', 'genders.id')
                        ->join('countries', 'applicant_infos.country_id', '=', 'countries.id')
                        ->join('nationalities', 'applicant_infos.nationality_id', '=', 'nationalities.id')
                        ->join('currencies', 'applicant_infos.currency_id', '=', 'currencies.id')
                        ->join('degrees', 'applicant_infos.degree_id', '=', 'degrees.id')
                        ->join('courses', 'applicant_infos.course_id', '=', 'courses.id')
                        ->where('user_id', Auth::id())
                        ->get();
        // $country_code = Country::where('country_name', $app_profile->country)->first();

        // return $app_profile;
        return view('applicant_profile')->with('profile', $app_profile);
        //                                 ->with('country_code', $country_code);
    }
    
    public function editApplicantProfile($user_id)
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'));
        }

        $app_profile = ApplicantInfo::where('user_id', $user_id)->first();
        $genders = Gender::all();
        $countries = Country::all();
        $nationalities = Nationality::all();
        $currencies = Currency::all();
        $degrees = Degree::all();
        $courses = Course::all();

        $data = [
            'app_profile' => $app_profile,
            'genders' => $genders,
            'nationalities' => $nationalities,
            'countries' => $countries,
            'currencies' => $currencies,
            'degrees' => $degrees,
            'courses' => $courses
        ];

        return view('edit_app_profile')->with('data', $data);
    }

    public function updateApplicantProfile(Request $request, $id, $user_id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'country' => 'required',
            'nationality' => 'required',
            'mobile_phone_no' => [
                'required',
                "unique:applicant_infos,mobile_phone_no, ".$id,
                'size: 11',
                'regex:/^(?!(?:09[0][1-4]|[8][34678]|[9][01])[0-9]{7}$)\d+/'
            ],
            'profile_picture' => 'image|nullable|max:1999',
            'resume' => 'mimes:pdf|nullable|max:2048',
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
            $path = $request->file('profile_picture')->storeAs('public/app_profile_pictures', $img_filename);
        }

        if ($request->hasFile('resume')) {
            // Get original file name (on upload)
            $pdf_orig_filename = $request->file('resume')->getClientOriginalName();
            // Get original file name without extension
            $filename_pdf = pathinfo($pdf_orig_filename, PATHINFO_FILENAME);
            // Get original file name extension
            $extension_pdf = $request->file('resume')->getClientOriginalExtension();
            // Filename to be stored (filename + timestamp + extension)
            $pdf_filename = $filename_pdf.'_'.time().'.'.$extension_pdf;
            // Upload profile picture
            $path_pdf = $request->file('resume')->storeAs('public/app_resume', $pdf_filename);
        }

        $app_profile = ApplicantInfo::where('user_id', $user_id)->first();
        $app_profile->first_name = $request->input('first_name');
        $app_profile->last_name = $request->input('last_name');
        $app_profile->age = $request->input('age');
        $app_profile->gender_id = $request->input('gender');
        $app_profile->address = $request->input('address');
        $app_profile->country_id = $request->input('country');
        $app_profile->nationality_id = $request->input('nationality');
        
        if ($app_profile->mobile_phone_no !== $request->input('mobile_phone_no')) {
            $app_profile->mobile_phone_no = $request->input('mobile_phone_no');
        }
        
        if ($request->hasFile('profile_picture')) {
            $app_profile->profile_picture = $img_filename;
        }

        if ($request->hasFile('resume')) {
            $app_profile->resume = $pdf_filename;
        }
        
        $app_profile->job_title = $request->input('job_title');
        $app_profile->company_name = $request->input('company_name');
        $app_profile->start_date = $request->input('start_date');
        
        if($request->input('end_date')) {
            $app_profile->end_date = $request->input('end_date');
        }

        $app_profile->currency_id = $request->input('currency');
        $app_profile->salary = $request->input('salary');
        $app_profile->tasks = $request->input('tasks');
        $app_profile->university = $request->input('university');
        $app_profile->degree_id = $request->input('degree');
        $app_profile->course_id = $request->input('course');
        $app_profile->univ_start_date = $request->input('univ_start_date');
        $app_profile->univ_end_date = $request->input('univ_end_date');
        $app_profile->save();
        
        // return $app_profile;
        return redirect('/home')->with('success', 'Nice! You updated your profile.');
    }

    public function storeApplicantJobPostApplication($job_post_id, $company_id)
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'));
        }

        // Check if job post already saved in job_posts_applications db
        $apply_jp_status = JobPostApplication::where(['user_id' => Auth::id(), 'comp_id' => $company_id, 'job_post_id' => $job_post_id])->first();

        if ($apply_jp_status) {
            return redirect('/job-search')->with('error', 'You already applied to this job post.');
        }

        // Save to db
        $apply_to_job_post = new JobPostApplication;
        $apply_to_job_post->user_id = Auth::id();
        $apply_to_job_post->comp_id = $company_id;
        $apply_to_job_post->job_post_id = $job_post_id;
        $apply_to_job_post->save();    

        return redirect('/job-search')->with('success', 'Your application to this job post has been sent successfully.');
    }

    public function showActiveApplications()
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'));
        }

        $active_applications = DB::table('job_post_applications')
                            ->select('job_post_applications.*', 'job_posts.title' ,'employer_infos.company_name', 'job_application_statuses.status')
                            ->join('job_posts', 'job_post_applications.job_post_id', '=', 'job_posts.id')
                            ->join('employer_infos', 'job_post_applications.comp_id', '=', 'employer_infos.comp_id')
                            ->join('job_application_statuses', 'job_post_applications.app_status_id', '=', 'job_application_statuses.id')
                            ->where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        // return $active_applications;
        return view('active_applications')->with('applications', $active_applications);
    }

    public static function getJobPostApplicantsCount($job_post_id, $comp_id)
    {
        $applicants_count = DB::table('job_post_applications')
                            ->where('job_post_id', $job_post_id)
                            ->where('comp_id', $comp_id)
                            ->count();

        return $applicants_count;
    }

    public function acceptInterviewInvitation($job_post_app_id)
    {
        $application = JobPostApplication::find($job_post_app_id);
        $application->app_status_id = 4;
        // return $application;
        $application->save();
        
        return redirect()->back()->with('success', 'Congrats! Your interview appointment has been confirmed.');
    }

    public function declineInterviewInvitation($job_post_app_id)
    {
        $application = JobPostApplication::find($job_post_app_id);
        $application->app_status_id = 5;
        // return $application;
        $application->save();
        
        return redirect()->back()->with('success', 'You have declined the interview invitation.');
    }

    public function removeApplicantJobPostApplication($job_post_app_id)
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'));
        }

        $application = JobPostApplication::where(['id' => $job_post_app_id, 'user_id' => Auth::id()])->first();
        $application->delete();

        return redirect('/active-applications')->with('success', 'Your application has been withdrawn.');
    }

    public function saveJobPost($job_post_id, $company_id)
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'));
        }

        // Check if job post already saved in saved_job_posts db
        $save_jp_status = SavedJobPost::where(['user_id' => Auth::id(), 'comp_id' => $company_id, 'job_post_id' => $job_post_id])->first();

        if ($save_jp_status) {
            return redirect('/job-search')->with('error', 'You already saved this job post.');
        }

        // Save to db
        $saved_job_post = new SavedJobPost;
        $saved_job_post->user_id = Auth::id();
        $saved_job_post->comp_id = $company_id;
        $saved_job_post->job_post_id = $job_post_id;
        $saved_job_post->save();    

        return redirect('/job-search')->with('success', 'The job post has been saved.');
    }

    public function showSavedJobPosts()
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'));
        }

        $saved_job_posts = DB::table('saved_job_posts')
                            ->select('saved_job_posts.*', 'job_posts.title' ,'employer_infos.company_name')
                            ->join('job_posts', 'saved_job_posts.job_post_id', '=', 'job_posts.id')
                            ->join('employer_infos', 'saved_job_posts.comp_id', '=', 'employer_infos.comp_id')
                            ->where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('saved_jobs')->with('job_posts', $saved_job_posts);
    }

    public function unsaveJobPost($saved_job_post_id)
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'));
        }

        $job_post = SavedJobPost::where(['id' => $saved_job_post_id, 'user_id' => Auth::id()])->first();;
        $job_post->delete();

        return redirect('/saved-job-posts')->with('success', 'The job listing has been unsaved.');
    }
}
