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
        return $next($request);
    }
}
