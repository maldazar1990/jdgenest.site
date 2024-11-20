<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class TwoFactorAuthController extends Controller
{
    public function confirm(Request $request)
    {
        $confirmed = $request->user()->confirmTwoFactorAuth($request->code);

        if (!$confirmed) {
            Session::flash('error_code', '1');
            return back()->withErrors('Code d\'authentification à deux facteurs invalide');
        }
        return back()->with('message', 'L\'authentification à deux facteurs a été confirmée')
        ->with("two-factor-authentication-confirmed", true);	
    }
}