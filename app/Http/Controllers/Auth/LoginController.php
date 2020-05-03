<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest',  ['except' => ['logout', 'userLogout']]);
    }

    public function showLoginForm()
    {
        if(!session()->has('url.intended'))
        {
            $url_prev = url()->previous();
            // $url_check = url()->route('site.main').'/';

            switch($url_prev) {
                case url()->route('site.main').'/':
                    break;
                case url()->route('site.about_us'):
                    break;
                case url()->route('site.contact_us'):
                    break;
                default:
                    session(['url.intended' => url()->previous()]);       
            }
        }

        
        return view('auth.login');
    }


    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
        // if ($response = $this->loggedOut($request)) {
        //     return $response;
        // }

        // return $request->wantsJson()
        //     ? new Response('', 204)
        //     : redirect('/');
    }
}

