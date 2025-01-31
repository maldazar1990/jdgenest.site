<?php

namespace App\Http\Middleware;

use App\FirewallIp;
use App\Repository\FireWallRepository;
use Closure;
use http\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TestFuzzBlock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    function detectFuzz(Request $request) {
        $fuzz = array(
            'wp-admin',
            'wp-login',
            'wp-content',
            'wp-includes',
            'wp-json',
            "index.php",
            "xmlrpc.php",
            "wp-",
            "wp-activate",
            "wp-blog-header",
            "storage",
            "app",
            "config",
            "bootstrap",
            "artisan",
            "composer",
            ".env");
        foreach ($fuzz as $fuzz) {
            if (strpos($request->path(), $fuzz) !== false) {
                return true;
            }
        }
    }

    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $publicIp = Cache::remember("publicIp", 60*60*24, function () {
            $curl = curl_init();

            // set our url with curl_setopt()
            curl_setopt($curl, CURLOPT_URL, "http://httpbin.org/ip");

            // return the transfer as a string, also with setopt()
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            // curl_exec() executes the started curl session
            // $output contains the output string
            $output = curl_exec($curl);

            // close curl resource to free up system resources
            // (deletes the variable made by curl_init)
            curl_close($curl);

            $ip = json_decode($output, true);

            return $ip['origin'];
        });
        if ( (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) or $ip == $publicIp ) {
            if ( $request->isMethod("GET") and !$request->ajax() ) {
                if (Cache::has("url")) {
                    $urls = Cache::get("url");
                } else {
                    $urls = collect();
                    foreach( \App\post::where('status',0)->get() as $post ) {
                        $urls->add( route("post", $post->slug));


                    }
                    $urls->add( route("default",));
                    $urls->add( route("about",));
                    $urls->add( route("contact",));
                    $urls->add( "/");

                    Cache::put("url",$urls, 60*60*24);
                }

                if ( !$urls->contains( function ( string $value, $key ) use($request) {
                    return str_contains($request->path(),$value);
                }) ) {
                    if ( $this->detectFuzz($request) ) {
                        FireWallRepository::createReport($request->ip(),2,"fuzz");
                        abort(403);
                    }
                }


            }
        }
        return $next($request);
    }
}
