<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchBot
{

    function crawlerDetect($USER_AGENT)
    {
        $crawlers = array(
            'Google' => 'Google',
            'MSN' => 'msnbot',
            'Rambler' => 'Rambler',
            'Yahoo' => 'Yahoo',
            'AbachoBOT' => 'AbachoBOT',
            'accoona' => 'Accoona',
            'AcoiRobot' => 'AcoiRobot',
            'ASPSeek' => 'ASPSeek',
            'CrocCrawler' => 'CrocCrawler',
            'Dumbot' => 'Dumbot',
            'FAST-WebCrawler' => 'FAST-WebCrawler',
            'GeonaBot' => 'GeonaBot',
            'Gigabot' => 'Gigabot',
            'Lycos spider' => 'Lycos',
            'MSRBOT' => 'MSRBOT',
            'Altavista robot' => 'Scooter',
            'AltaVista robot' => 'Altavista',
            'ID-Search Bot' => 'IDBot',
            'eStyle Bot' => 'eStyle',
            'Scrubby robot' => 'Scrubby',
            'Facebook' => 'facebookexternalhit',
        );
        // to get crawlers string used in function uncomment it
        // it is better to save it in string than use implode every time
        // global $crawlers
        $crawlers_agents = implode('|',$crawlers);
        if (strpos($crawlers_agents, $USER_AGENT) === false)
            return false;
        else {
            return TRUE;
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->crawlerDetect($request->header('User-Agent'))) {
            return redirect()->route('default');
        }

        return $next($request);
    }
}
