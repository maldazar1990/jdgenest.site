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
            return back()->withErrors('Code d\'authentification à deux facteurs invalide');
        }
        return back()->with('message', 'L\'authentification à deux facteurs a été confirmée')
        ->with("two-factor-authentication-confirmed", true);	
    }
}