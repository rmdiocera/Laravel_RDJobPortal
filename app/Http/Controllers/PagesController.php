<?php

namespace App\Http\Controllers;

use App\Country;
use App\Course;
use App\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;


class PagesController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function showJobPosts()
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

    public function about()
    {
        return view('pages.about');
    }

    public function contactUs()
    {
        return view('pages.contact_us');
    }
}
