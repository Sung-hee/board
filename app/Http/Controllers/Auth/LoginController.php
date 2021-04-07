<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\EmailLogin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, ['email' => 'required|email|exists:users']);

        $emailLogin = EmailLogin::createForEmail($request->input('email'));

        $url = route('auth.email-authenticate', [
            'token' => $emailLogin->token
        ]);

        Mail::send('auth.emails.email-login', ['url' => $url], function ($m) use ($request) {
            $m->from('klpoik326@gmail.com', 'Laravel');
            $m->to($request->input('email'))->subject('Verify Email Address');
        });

        return view('auth.emails.email-send-success');
    }

    public function authenticateEmail($token)
    {
        $emailLogin = EmailLogin::validFromToken($token);

        Auth::login($emailLogin->user);

        return redirect('home');
    }
}
