<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    protected $redirectTo = RouteServiceProvider::ADMINHOME;
    protected $maxAttempts = 3;
    protected $decayMinutes = 1;

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
        $credentials = [
            "email" => $request->email,
            'password' => $request->password,
        ];

        if(!Auth::validate($credentials)){
            return redirect()->to('login')
                ->withErrors(['email' => 'Email ou mot de passe incorrect']);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();
            return $this->authenticated($request, $user);
        }
        return redirect()->to('login')
            ->withErrors(['email' => 'Email ou mot de passe incorrect']);


    }

    public function authenticated(Request $request, $user)
    {
        Auth::logoutOtherDevices($request->password);
        
        if($user->hasRole('admin')) {
            return redirect()->route("admin");
        }
        return redirect()->route("default");
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect("/");
    }
}
