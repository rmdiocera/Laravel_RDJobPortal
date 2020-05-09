<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class EmployerLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:employer', ['except' => ['logout']]);   
    }

    public function showLoginForm()
    {
        if(!session()->has('url.intended'))
        {
            $url_prev = url()->previous();

            if ($url_prev == url()->route('site.job_search')) {
                session(['url.intended' => url()->route('employer.job_posts')]);   
            } else {
                session(['url.intended' => url()->previous()]);
            }
        }
        
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

    public function logout()
    {
        Auth::guard('employer')->logout();
        return redirect('/');
        // if ($response = $this->loggedOut($request)) {
        //     return $response;
        // }

        // return $request->wantsJson()
        //     ? new Response('', 204)
        //     : redirect('/');
    }

}
