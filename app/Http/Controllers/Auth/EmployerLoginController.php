<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Validation\ValidationException;
use Auth;

class EmployerLoginController extends Controller
{
    use ThrottlesLogins;

    public function __construct()
    {
        $this->middleware(['guest:web', 'guest:employer'], ['except' => ['logout']]);   
    }

    public function showLoginForm()
    {
        if(!session()->has('url.intended'))
        {
            $url_prev = url()->previous();

            if ($url_prev == url()->route('site.job_search')) {
                session(['url.intended' => url()->route('employer.job_posts')]);   
            } else if ($url_prev == url()->route('site.main').'/') {
                session(['url.intended' => url()->route('employer.dashboard')]);
            } else {
                session(['url.intended' => url()->previous()]);
            }
        }
        
        return view('auth.employer-login');
    }

    public function sendFailedLoginResponse()
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (Auth::guard('employer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('employer.dashboard'));
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse();
        // return redirect()->back()->with('error','These credentials do not match anything in our site.')->withInput($request->only('email', 'remember'));
        
    }

    public function username()
    {
        return 'email';
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
