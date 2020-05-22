<?php

namespace App\Http\Controllers;

use App\EmpType;
use App\Industry;
use App\JobLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Uninstall this
// use Rap2hpoutre\FastExcel\FastExcel;

class PagesController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function testSort(Request $request)
    {
        $industries = Industry::all();
        $emp_types = EmpType::all();
        $job_levels = JobLevel::all();

        $filter_by = [
            'industries' => $industries,
            'emp_types' => $emp_types,
            'levels' => $job_levels 
        ];

        $industry = $request->input('industry');
        $emp_type = $request->input('emp_type');
        $level = $request->input('level');

        $results = DB::table('job_posts')
                    ->select('job_posts.*', 'employer_infos.company_name', 'industries.industry', 'emp_types.emp_type', 'job_levels.job_level')
                    ->join('employer_infos', 'job_posts.comp_id', '=', 'employer_infos.comp_id')
                    ->join('industries', 'job_posts.industry_id', '=', 'industries.id')
                    ->join('emp_types', 'job_posts.emp_type_id', '=', 'emp_types.id')
                    ->join('job_levels', 'job_posts.level_id', '=', 'job_levels.id')
                    ->when($industry, function ($query, $industry) {
                        return $query->where('job_posts.industry_id', $industry);
                    })
                    ->when($emp_type, function ($query, $emp_type) {
                        return $query->where('job_posts.emp_type_id', $emp_type);
                    })
                    ->when($level, function ($query, $level) {
                        return $query->where('job_posts.level_id', $level);
                    })
                    ->whereNull('job_posts.deleted_at')
                    ->get();
        
        return view('job_search.job_search')->with('results', $results)
                                            ->with('filter_by', $filter_by)
                                            ->with('industry_id', $industry)
                                            ->with('emp_type_id', $emp_type)
                                            ->with('level_id', $level);
    }

    public function showJobPosts(Request $request)
    {
        $industries = Industry::all();
        $emp_types = EmpType::all();
        $job_levels = JobLevel::all();

        $filter_by = [
            'industries' => $industries,
            'emp_types' => $emp_types,
            'levels' => $job_levels 
        ];

        $search_query = $request->input('search');

        $industry = $request->input('industry');
        $emp_type = $request->input('emp_type');
        $level = $request->input('level');
        $order_by = $request->input('sort_by');

        $order_by_col = 'created_at';
        $order = 'desc';

        switch ($order_by) {
            case 1:
                $order_by_col = 'created_at';
                $order = 'desc';
                break;

            case 2:
                $order_by_col = 'company_name';
                $order = 'asc';
                break;
            
            case 3:
                $order_by_col = 'title';
                $order = 'asc';
        }

        if ($search_query) {  
            if ($search_query && $search_query != "") {
                $results = DB::table('job_posts')
                            ->select('job_posts.*', 'employer_infos.company_name', 'employer_infos.profile_picture', 'industries.industry', 'emp_types.emp_type', 'job_levels.job_level')
                            ->join('employer_infos', 'job_posts.comp_id', '=', 'employer_infos.comp_id')
                            ->join('industries', 'job_posts.industry_id', '=', 'industries.id')
                            ->join('emp_types', 'job_posts.emp_type_id', '=', 'emp_types.id')
                            ->join('job_levels', 'job_posts.level_id', '=', 'job_levels.id')
                            ->when($industry, function ($query, $industry) {
                                return $query->where('job_posts.industry_id', $industry);
                            })
                            ->when($emp_type, function ($query, $emp_type) {
                                return $query->where('job_posts.emp_type_id', $emp_type);
                            })
                            ->when($level, function ($query, $level) {
                                return $query->where('job_posts.level_id', $level);
                            })
                            ->where('title', 'LIKE', '%'.$search_query.'%')
                            ->whereNull('job_posts.deleted_at')
                            ->orderBy($order_by_col, $order)
                            ->paginate(5);

                if (count($results) > 0) {
                    return view('job_search.job_search')->with('filter_by', $filter_by)
                                                        ->with('results', $results)
                                                        ->with('search', $search_query)
                                                        ->with('industry_id', $industry)
                                                        ->with('emp_type_id', $emp_type)
                                                        ->with('level_id', $level)
                                                        ->with('order_by_id', $order_by); 
                }
    
                return redirect()->back()->with('error', 'Your search has no results found. Please try again.');
            } 
        } else {
            $job_posts = DB::table('job_posts')
                        ->select('job_posts.*', 'employer_infos.company_name', 'employer_infos.profile_picture', 'industries.industry', 'emp_types.emp_type', 'job_levels.job_level')
                        ->join('employer_infos', 'job_posts.comp_id', '=', 'employer_infos.comp_id')
                        ->join('industries', 'job_posts.industry_id', '=', 'industries.id')
                        ->join('emp_types', 'job_posts.emp_type_id', '=', 'emp_types.id')
                        ->join('job_levels', 'job_posts.level_id', '=', 'job_levels.id')
                        ->when($industry, function ($query, $industry) {
                            return $query->where('job_posts.industry_id', $industry);
                        })
                        ->when($emp_type, function ($query, $emp_type) {
                            return $query->where('job_posts.emp_type_id', $emp_type);
                        })
                        ->when($level, function ($query, $level) {
                            return $query->where('job_posts.level_id', $level);
                        })
                        ->whereNull('job_posts.deleted_at')
                        ->orderBy($order_by_col, $order)
                        ->paginate(5);

            return view('job_search.job_search')->with('filter_by', $filter_by)
                                                ->with('job_posts', $job_posts)
                                                ->with('industry_id', $industry)
                                                ->with('emp_type_id', $emp_type)
                                                ->with('level_id', $level)
                                                ->with('order_by_id', $order_by);
        }

        // return redirect()->back()->with('error', 'You didn\'t enter anything on the search bar.');
        
    }

    public function showSearchResults(Request $request)
    {
        $search_query = $request->input('search');
        
        if ($search_query == "") {
            return redirect('/')->with('error', 'Your search contains no keywords. Please try again.');
        }

        $results = DB::table('job_posts')
                        ->select('job_posts.*', 'industries.industry', 'emp_types.emp_type', 'job_levels.job_level')
                        ->join('industries', 'job_posts.industry_id', '=', 'industries.id')
                        ->join('emp_types', 'job_posts.emp_type_id', '=', 'emp_types.id')
                        ->join('job_levels', 'job_posts.level_id', '=', 'job_levels.id')
                        ->where('title', 'LIKE', '%'.$search_query.'%')
                        ->whereNull('job_posts.deleted_at')
                        ->get();
        
        if (count($results) > 0) {
            return view('pages.search_results')->with('results', $results); 
        }

        // return view('pages.search_results');
        return view('pages.search_results')->withMessage('error', 'Your search has no results found. Please try again.');   
    }

    public function viewCompanyProfile($comp_id)
    {
        if(request()->ajax())
        {
            $company_profile = DB::table('employer_infos')
                            ->select('employer_infos.*', 'industries.industry')
                            ->join('industries', 'employer_infos.industry_id', '=', 'industries.id')
                            ->where('comp_id', $comp_id)
                            ->get();
            
            return response()->json(['company' => $company_profile]);
        }
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
