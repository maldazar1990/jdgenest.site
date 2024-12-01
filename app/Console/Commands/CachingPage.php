<?php

namespace App\Console\Commands;

use App\options_table;
use App\post;
use App\Users;
use http\Url;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
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
            $slug = $post->slug;
            $response = Http::get(route("post", $slug));
            echo "Caching post: ".$slug."\n";
            echo "Status: ".$response->status()."\n";
            \Log::info("Caching post: ".$slug);
            \Log::info("Status: ".$response->status());

            Cache::rememberForever("post_id_".$slug,function() use ($slug){
                return post::where("id",$slug)->first();
            });

            Cache::rememberForever("post_comments_".$post->id,function() use ($post){
                return $post->comments()->get();
            });



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


        if (Cache::has("optionsArray")) {
             Cache::get("optionsArray");
        } else {
            $options = options_table::all()->pluck('option_value', 'option_name')->toArray();
            Cache::put("optionsArray",$options);
        }

        Cache::rememberForever('userInfo',function(){
            return Users::find(1)->first();
        });

        Cache::rememberForever('allPosts',function(){
            return post::where("post.status",0)
                ->where("created_at","<=",now())
                ->orderBy('post.created_at', 'desc')
                ->orderBy('post.id', 'desc')

                ->paginate(config("app.maxblog"));
        });

    }
}
