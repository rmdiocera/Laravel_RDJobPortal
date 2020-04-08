<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Validator;
// use App\Providers\RouteServiceProvider;

class EmployerRegisterController extends Controller
{

    // protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest:employer');   
    }

    public function showRegistrationForm()
    {
        return view('auth.employer-register');
    }

    public function register(Request $request)
    {  
        request()->validate([
        'username' => 'required',
        'email' => 'required|email|unique:employers',
        'password' => 'required|min:6|confirmed',
        ]);
         
        $data = $request->all();
 
        $employer = $this->create($data);
       
        $this->guard()->login($employer);

        return redirect()->route('employer.create_profile');
    }

    public function create(array $data)
    {
      return Employer::create([
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    protected function guard()
    {
        return Auth::guard('employer');
    }
}
