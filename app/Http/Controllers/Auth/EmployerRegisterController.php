<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use App\Providers\RouteServiceProvider;

class EmployerRegisterController extends Controller
{

    // protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware(['guest:web', 'guest:employer']);   
    }

    public function showRegistrationForm()
    {
        return view('auth.employer-register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function register(Request $request)
    {  
        // request()->validate([
        //     'username' => 'required',
        //     'email' => 'required|email|unique:employers',
        //     'password' => 'required|min:8|confirmed',
        // ]);
        $data = $request->all();

        $validation = $this->validator($data);
 
        if ($validation->fails()) {
            return redirect(route('employer.register'))
                ->withErrors($validation)
                ->withInput();
        }

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
