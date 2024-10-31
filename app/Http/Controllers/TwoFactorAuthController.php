<?php

namespace App\Http\Controllers;

use Akaunting\Firewall\Middleware\Session;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class TwoFactorAuthController extends Controller
{
    public function confirm(Request $request)
    {
        $confirmed = $request->user()->confirmTwoFactorAuth($request->code);

        if (!$confirmed) {
            return back()->withErrors('Invalid Two Factor Authentication code');
        }
        return back()->with('message', 'Two Factor Authentication has been confirmed')
        ->with("two-factor-authentication-confirmed", true);	
    }
}