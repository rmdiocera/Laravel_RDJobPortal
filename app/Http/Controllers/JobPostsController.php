<?php

namespace App\Http\Controllers;

use App\EmpType;
use App\Industry;
use App\JobLevel;
use Illuminate\Http\Request;
use App\JobPost;
use DB;

class JobPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $job_posts = DB::table('job_posts')
                        ->select('job_posts.*', 'industries.industry', 'emp_types.emp_type', 'job_levels.job_level')
                        ->join('industries', 'job_posts.industry_id', '=', 'industries.id')
                        ->join('emp_types', 'job_posts.emp_type_id', '=', 'emp_types.id')
                        ->join('job_levels', 'job_posts.level_id', '=', 'job_levels.id')
                        ->whereNull('job_posts.deleted_at')
                        ->get();
        
        return view('job_search.job_search')->with('job_posts', $job_posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $job_post->comp_id = 1;
        $job_post->industry_id = $request->input('industry');
        $job_post->emp_type_id = $request->input('emp_type');
        $job_post->level_id = $request->input('level');
        $job_post->title = $request->input('title');
        $job_post->desc = $request->input('description');
        $job_post->save();

        return redirect('/job-search')->with('success', 'Your job listing has been posted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job_post = JobPost::find($id);
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
        $job_post->comp_id = 1;
        $job_post->industry_id = $request->input('industry');
        $job_post->emp_type_id = $request->input('emp_type');
        $job_post->level_id = $request->input('level');
        $job_post->title = $request->input('title');
        $job_post->desc = $request->input('description');
        $job_post->save();

        return redirect('/job-search')->with('success', 'Your job listing has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job_post = JobPost::find($id);
        $job_post->delete();

        return redirect('/job-search')->with('success', 'Your job listing has been deleted.');
    }
}
