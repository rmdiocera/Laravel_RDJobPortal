<?php

namespace App\Http\Controllers;

use App\ApplicantInfo;
use App\Country;
use App\Course;
use App\Currency;
use App\Degree;
use App\Gender;
use App\Http\Requests\SaveApplicantProfile;
use App\Http\Requests\UpdateApplicantProfile;
use App\JobApplicationStatus;
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
            return redirect(route('user.create_profile'))->with('warning', 'Please complete your personal information to proceed.');
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
    
    public function redirectToCreateApplicantProfile() 
    {
        return redirect(route('user.create_profile'))->with('warning', 'Please complete your personal information to proceed.');
    }

    public function saveApplicantProfile(SaveApplicantProfile $request)
    {
        $validated = $request->validated();
        
        if (!$validated) {
            return back()->withErrors($validated)->withInput();
        }
    // $validated = $this->validate($request, [
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'age' => 'required',
    //         'gender' => 'required',
    //         'address' => 'required',
    //         'country' => 'required',
    //         'nationality' => 'required',
    //         'mobile_phone_no' => array(
    //             'required',
    //             'unique:applicant_infos,mobile_phone_no',
    //             'size: 11',
    //             'regex:/^09(?!(?:[0][0-4]|[8][34678]|[9][01])[0-9]{7}$)\d+/'
    //         ),
    //         'profile_picture' => 'image|nullable|max:1999',
    //         'resume' => 'mimes:pdf|nullable|max:1999',
    //         'job_title' => 'required',
    //         'company_name' => 'required',
    //         'start_date' => 'required',
    //         'currency' => 'required',
    //         'salary' => 'required',
    //         'tasks' => 'required',
    //         'university' => 'required',
    //         'degree' => 'required',
    //         'course' => 'required',
    //         'univ_start_date' => 'required',
    //         'univ_end_date' => 'required',
    //     ],
    //     [
    //         'first_name.required' =>  'The First Name field is required.',
    //         'last_name.required' =>  'The Last Name field is required.',
    //         'age.required' =>  'The Age field is required.',
    //         'gender.required' =>  'The Gender field is required.',
    //         'address.required' =>  'The Address field is required.',
    //         'country.required' =>  'The Country field is required.',
    //         'nationality.required' =>  'The Nationality field is required.',
    //         'mobile_phone_no.required' =>  'The Phone Number field is required.',
    //         'mobile_phone_no.unique' =>  'The phone number you entered has already been used.',
    //         'mobile_phone_no.size' =>  'The phone number must be 11 digits.',
    //         'mobile_phone_no.regex' =>  'The phone number must be a valid phone number in the Philippines.',
    //         'profile_picture.image' =>  'The profile picture must be an image.',
    //         'profile_picture.uploaded' =>  'Maximum file size for a profile picture is 2MB.',
    //         'resume.mimes' => 'The filename uploaded must be a file type of .pdf',
    //         'resume.uploaded' =>  'Maximum file size for a resume is 2MB.',
    //         'job_title.required' =>  'The Job Title field is required.',
    //         'company_name.required' =>  'The Company Name field is required.',
    //         'start_date.required' =>  'The Start Date field is required.',
    //         'mobile_phone_no.required' =>  'The Phone Number field is required.',
    //         'currency.required' =>  'The Currency field is required.',
    //         'salary.required' =>  'The Salary field is required.',
    //         'tasks.required' =>  'The Tasks field is required.',
    //         'university.required' =>  'The University field is required.',
    //         'degree.required' =>  'The Degree field is required.',
    //         'course.required' =>  'The Course field is required.',
    //         'univ_start_date.required' =>  'The Start Date (University/College) field is required.',
    //         'univ_end_date.required' =>  'The Date of Graduation field is required.',
    //     ]
    // );

    //     if (!$validated) {
    //         return back()->withErrors($validated)->withInput();
    //     }

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
        return redirect('/home/show-profile')->with('success', 'Congratulations! You completed your profile.');
    }

    public function showApplicantProfile()
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'))->with('warning', 'Please complete your personal information to proceed.');
        }

        $app_profile = DB::table('applicant_infos')
                        ->select('applicant_infos.*', 'users.email', 'genders.gender', 'countries.country_code', 'countries.country_name', 'nationalities.nationality', 'currencies.currency', 'degrees.degree', 'courses.course')
                        ->join('users', 'applicant_infos.user_id', '=', 'users.id')
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
        // echo auth()->user()->id;
        // echo $user_id; 

        // if (auth()->user()->id != 2) {
        //     echo "not equal";
        // }
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'))->with('warning', 'Please complete your personal information to proceed.');
        }

        if (auth()->user()->id != $user_id) {
            return redirect('home/show-profile')->with('warning', 'You are not authorized to view this page.');
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

    public function updateApplicantProfile(UpdateApplicantProfile $request, $user_id)
    {
        $validated = $request->validated();

        if (!$validated) {
            return back()->withErrors($validated)->withInput();
        }
        // $this->validate($request, [
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        //     'age' => 'required',
        //     'gender' => 'required',
        //     'address' => 'required',
        //     'country' => 'required',
        //     'nationality' => 'required',
        //     'mobile_phone_no' => [
        //         'required',  
        //         "unique:applicant_infos,mobile_phone_no, ".$id,
        //         'size: 11',
        //         'regex:/^09(?!(?:[0][0-4]|[8][34678]|[9][01])[0-9]{7}$)\d+/'
        //     ],
        //     'profile_picture' => 'image|nullable|max:1999',
        //     'resume' => 'mimes:pdf|nullable|max:2048',
        //     'job_title' => 'required',
        //     'company_name' => 'required',
        //     'start_date' => 'required',
        //     'currency' => 'required',
        //     'salary' => 'required',
        //     'tasks' => 'required',
        //     'university' => 'required',
        //     'degree' => 'required',
        //     'course' => 'required',
        //     'univ_start_date' => 'required',
        //     'univ_end_date' => 'required',
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
        $app_profile->mobile_phone_no = $request->input('mobile_phone_no');
        
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
        return redirect('home/show-profile')->with('success', 'Nice! You updated your profile.');
    }

    public function storeApplicantJobPostApplication(Request $request)
    {
        if(request()->ajax())
        {
            if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
                return response()->json(['url' => route('user.redirect_to_create_profile')]);
            }

            // Check if job post already saved in job_posts_applications db
            $apply_jp_status = JobPostApplication::where(['user_id' => Auth::id(), 'job_post_id' => $request->input('job_post_id'), 'comp_id' => $request->input('comp_id')])->first();

            if ($apply_jp_status) {
                return response()->json(['error' => 'You already applied to this job post.']);
                // return redirect('/job-search')->with('error', 'You already applied to this job post.');
            }

            // Save to db
            $apply_to_job_post = new JobPostApplication;
            $apply_to_job_post->user_id = Auth::id();
            $apply_to_job_post->job_post_id = $request->input('job_post_id');
            $apply_to_job_post->comp_id = $request->input('comp_id');
            $apply_to_job_post->save();    

            return response()->json(['success' => 'Your application to this job post has been sent successfully.']);
            // return redirect('/job-search')->with('success', 'Your application to this job post has been sent successfully.');
        }
    }

    public function showActiveApplications()
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'))->with('warning', 'Please complete your personal information to proceed.');
        }

        $active_applications = DB::table('job_post_applications')
                            ->select('job_post_applications.*', 'job_posts.title' , 'employer_infos.company_name', 'employer_infos.profile_picture', 'job_application_statuses.status')
                            ->join('job_posts', 'job_post_applications.job_post_id', '=', 'job_posts.id')
                            ->join('employer_infos', 'job_post_applications.comp_id', '=', 'employer_infos.comp_id')
                            ->join('job_application_statuses', 'job_post_applications.app_status_id', '=', 'job_application_statuses.id')
                            ->where('user_id', Auth::id())
                            ->whereNull('job_posts.deleted_at')
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
        if(request()->ajax())
        {
            $application = JobPostApplication::find($job_post_app_id);
            $application->app_status_id = 4;
            $application->save();
            
            $app_status = JobApplicationStatus::where('id', $application->app_status_id)->pluck('status');

            return response()->json(['success' => 'Congrats! Your interview appointment has been confirmed.', 'status' => $app_status[0]]);
            // return redirect()->back()->with('success', 'Congrats! Your interview appointment has been confirmed.');
        }
    }

    public function declineInterviewInvitation($job_post_app_id)
    {
        if(request()->ajax())
        {
            $application = JobPostApplication::find($job_post_app_id);
            $application->app_status_id = 5;
            $application->save();
            
            $app_status = JobApplicationStatus::where('id', $application->app_status_id)->pluck('status');

            return response()->json(['success' => 'You have declined the interview invitation.', 'status' => $app_status[0]]);
            // return redirect()->back()->with('success', 'You have declined the interview invitation.');
        }
    }

    public function removeApplicantJobPostApplication($job_post_app_id)
    {
        if(request()->ajax())
        {
            // if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            //     return redirect(route('user.create_profile'))->with('warning', 'Please complete your personal information to proceed.');
            // }
    
            $application = JobPostApplication::where(['id' => $job_post_app_id, 'user_id' => Auth::id()])->first();
            $application->delete();
    
            return response()->json(['success' => 'Your application has been withdrawn.']);
            // return redirect('/active-applications')->with('success', 'Your application has been withdrawn.');
        }
    }

    public function saveJobPost(Request $request)
    {
        if(request()->ajax())
        {
            if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
                return response()->json(['url' => route('user.redirect_to_create_profile')]);
            }

            // Check if job post already saved in saved_job_posts db
            $save_jp_status = SavedJobPost::where(['user_id' => Auth::id(), 'job_post_id' => $request->input('job_post_id'), 'comp_id' => $request->input('comp_id')])->first();

            if ($save_jp_status) {
                return response()->json(['error' => 'You already saved this job post.']);
                // return redirect('/job-search')->with('error', 'You already saved this job post.');
            }

            // Save to db
            $saved_job_post = new SavedJobPost;
            $saved_job_post->user_id = Auth::id();
            $saved_job_post->job_post_id = $request->input('job_post_id');
            $saved_job_post->comp_id = $request->input('comp_id');
            // return $saved_job_post;
            $saved_job_post->save();    

            return response()->json(['success' => 'The job post has been saved.']);
            // return redirect('/job-search')->with('success', 'The job post has been saved.');
        }
    }

    public function showSavedJobPosts()
    {
        if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            return redirect(route('user.create_profile'))->with('warning', 'Please complete your personal information to proceed.');
        }

        $saved_job_posts = DB::table('saved_job_posts')
                            ->select('saved_job_posts.*', 'job_posts.title' ,'employer_infos.company_name', 'employer_infos.profile_picture')
                            ->join('job_posts', 'saved_job_posts.job_post_id', '=', 'job_posts.id')
                            ->join('employer_infos', 'saved_job_posts.comp_id', '=', 'employer_infos.comp_id')
                            ->where('user_id', Auth::id())
                            ->whereNull('job_posts.deleted_at')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('saved_jobs')->with('job_posts', $saved_job_posts);
    }

    public function unsaveJobPost($saved_job_post_id)
    {
        if(request()->ajax())
        {
            // if (!ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
            //     return redirect(route('user.create_profile'))->with('warning', 'Please complete your personal information to proceed.');
            //     JSON response
            //     return response()->json(['url' => route('user.create_profile'), 'message' => 'Please complete your personal information to proceed.']);
            // }

            $job_post = SavedJobPost::where(['id' => $saved_job_post_id, 'user_id' => Auth::id()])->first();
            $job_post->delete();

            return response()->json(['success' => 'The job post has been unsaved.']);
            // return redirect('/saved-job-posts')->with('success', 'The job listing has been unsaved.');
        }    
    }
}
