<?php

namespace App\Http\Controllers;

use DB;
use App\EmployerInfo;
use App\EmpType;
use App\Industry;
use App\JobLevel;
use App\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!EmployerInfo::where('comp_id', Auth::user()->id)->first()) {
            return redirect(route('employer.create_profile'))->with('warning', 'Please complete your company information to proceed.');
        }

        $job_posts = DB::table('job_posts')
                        ->select('job_posts.*', 'employer_infos.company_name', 'employer_infos.profile_picture', 'industries.industry', 'emp_types.emp_type', 'job_levels.job_level')
                        ->join('employer_infos', 'job_posts.comp_id', '=', 'employer_infos.comp_id')
                        ->join('industries', 'job_posts.industry_id', '=', 'industries.id')
                        ->join('emp_types', 'job_posts.emp_type_id', '=', 'emp_types.id')
                        ->join('job_levels', 'job_posts.level_id', '=', 'job_levels.id')
                        ->where('job_posts.comp_id', Auth::id())
                        ->whereNull('job_posts.deleted_at')
                        ->orderBy('created_at', 'desc')
                        ->paginate(5);
        
        return view('job_search.job_search')->with('job_posts', $job_posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!EmployerInfo::where('comp_id', Auth::user()->id)->first()) {
            return redirect(route('employer.create_profile'))->with('warning', 'Please complete your company information to proceed.');
        }

        $industries = Industry::all();
        $emp_types = EmpType::all();
        $levels = JobLevel::all();

        $data = [
            'industries' => $industries,
            'emp_types' => $emp_types,
            'levels' => $levels
        ];

        return view('job_search.create_job_post')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'industry' => 'required',
            'emp_type' => 'required',
            'level' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        $job_post = new JobPost;
        $job_post->comp_id = Auth::user()->id;
        $job_post->industry_id = $request->input('industry');
        $job_post->emp_type_id = $request->input('emp_type');
        $job_post->level_id = $request->input('level');
        $job_post->title = $request->input('title');
        $job_post->desc = $request->input('description');
        $job_post->save();

        return redirect('/job-posts')->with('success', 'Your job listing has been posted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job_post = DB::table('job_posts')
                ->select('job_posts.*', 'employer_infos.company_name', 'employer_infos.profile_picture', 'industries.industry', 'emp_types.emp_type', 'job_levels.job_level')
                ->join('employer_infos', 'job_posts.comp_id', '=', 'employer_infos.id')
                ->join('industries', 'job_posts.industry_id', '=', 'industries.id')
                ->join('emp_types', 'job_posts.emp_type_id', '=', 'emp_types.id')
                ->join('job_levels', 'job_posts.level_id', '=', 'job_levels.id')
                ->where('job_posts.id', $id)
                ->get();

        return view('job_search.job_post')->with('job_post', $job_post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job_post = JobPost::find($id);
        $industries = Industry::all();
        $emp_types = EmpType::all();
        $levels = JobLevel::all();

        if (auth()->user()->id != $job_post->comp_id) {
            return redirect('job-posts')->with('warning', 'You are not authorized to view this page.');
        }

        $data = [
            'job_post' => $job_post,
            'industries' => $industries,
            'emp_types' => $emp_types,
            'levels' => $levels
        ];
        
        return view('job_search.edit_job_post')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'industry' => 'required',
            'emp_type' => 'required',
            'level' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        $job_post = JobPost::find($id);
        $job_post->comp_id = Auth::id();
        $job_post->industry_id = $request->input('industry');
        $job_post->emp_type_id = $request->input('emp_type');
        $job_post->level_id = $request->input('level');
        $job_post->title = $request->input('title');
        $job_post->desc = $request->input('description');
        $job_post->save();

        return redirect('/job-posts')->with('success', 'Your job listing has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(request()->ajax())
        {
            $job_post = JobPost::find($id);
            $job_post->delete();

            return response()->json(['success' => 'Your job listing has been deleted.']);
            // return redirect('/job-posts')->with('success', 'Your job listing has been deleted.');
        }
    }
}
