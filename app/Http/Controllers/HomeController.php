<?php

namespace App\Http\Controllers;

use App\Country;
use App\Currency;
use App\Nationality;
use Illuminate\Http\Request;

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
        return view('home');
    }

    public function showCreateApplicantProfile()
    {
        // if (ApplicantInfo::where('user_id', Auth::user()->id)->first()) {
        //     return redirect(route('user.dashboard'));
        // }

        $nationalities = Nationality::all();
        $countries = Country::all();
        $currencies = Currency::all();

        $data = [
            'nationalities' => $nationalities,
            'countries' => $countries,
            'currencies' => $currencies
        ];

        return view('profile.create_app_profile')->with('data', $data);
    }
}
