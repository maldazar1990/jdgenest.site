<?php

namespace App\Console\Commands;

use http\Url;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CachingPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:caching-page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach( \App\post::where('status',0)->get() as $post ) {
            $response = Http::get(route("post", $post->slug));
            echo "Caching post: ".$post->slug."\n";
            echo "Status: ".$response->status()."\n";
            \Log::info("Caching post: ".$post->slug);
            \Log::info("Status: ".$response->status());

        }
        $response = Http::get(route("default",));
        echo "Caching post: default \n";
        echo "Status: ".$response->status()."\n";
        \Log::info("Status: ".$response->status());
        $response = Http::get(route("about"));
        echo "Caching post: about \n";
        echo "Status: ".$response->status()."\n";
        \Log::info("Status: ".$response->status());
        $response = Http::get(route("contact"));
        echo "Caching post: contact \n";
        echo "Status: ".$response->status()."\n";
        \Log::info("Status: ".$response->status());

    }
}
