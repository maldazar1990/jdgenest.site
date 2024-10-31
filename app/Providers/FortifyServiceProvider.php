<?php

namespace App\Providers;

use App\Actions\Fortify\DisableTwoFactorAuthentication  as ActionsDisableTwoFactorAuthentication;
use App\Users as User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Features;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect('/');
            }
        });
    
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {   

                return \redirect(route("admin"));
            }
        });

        $this->app->bind(DisableTwoFactorAuthentication::class, function(){
            return new ActionsDisableTwoFactorAuthentication();
        });
    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::confirmPasswordView(function () {
            return view('auth.password-confirm');
        });

        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });


        Fortify::loginView(function(){
            return view('auth.login');
        });

        Fortify::authenticateUsing(function(Request $request){
            $user = User::where('email',$request->email)->first();

            if($user && Hash::check($request->password,$user->password)){
                return $user;
            }
        });

        Fortify::authenticateThrough(function (Request $request) {
            return array_filter([
                    config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                    Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
                    AttemptToAuthenticate::class,
                    PrepareAuthenticatedSession::class,
            ]);
        });

    }

    protected function configureRoutes()
    {
        Route::group([
            'namespace' => 'Laravel\Fortify\Http\Controllers',
            'domain' => config('fortify.domain', null),
            'prefix' => config('fortify.prefix'),
        ], function () {
            $this->loadRoutesFrom(base_path('routes/fortify.php'));
        });
    }

    
}
