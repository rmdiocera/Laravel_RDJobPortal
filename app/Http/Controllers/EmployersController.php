<?php

namespace App\Http\Controllers;

// use App\Providers\RouteServiceProvider;
// use App\Employer;
// use Illuminate\Foundation\Auth\RegistersUsers;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;

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
        $emp_profile->industry = $request->input('industry');
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
}
