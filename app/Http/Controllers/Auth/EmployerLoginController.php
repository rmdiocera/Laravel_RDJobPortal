<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class EmployerLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:employer');   
    }

    public function showLoginForm()
    {
        return view('auth.employer-login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('employer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('employer.dashboard'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
        
    }

}
