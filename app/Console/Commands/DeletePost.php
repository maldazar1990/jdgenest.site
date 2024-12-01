<?php

namespace App\Console\Commands;

use App\post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class DeletePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-post';

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
        \Log::info("Suppression des posts en cours");
        $posts = post::where("status", "2")->get();
        foreach($posts as $post){
            \Log::info("Suppression du post ".$post->title);
            if ( Cache::has('post_id_'.$post->id) )
                Cache::forget('post_id_'.$post->id);
            if ( Cache::has('post_slug_'.$post->id) )
                Cache::forget('post_slug_'.$post->id);

            $page = post::where('status', 0)->count() / config('app.maxblog');
            for ($i = 0; $i <= $page; $i++) {
                if ( Cache::has('post_page_'.$i) )
                    Cache::forget('post_page_'.$i);
            }
            $post->delete();
        }

        \Log::info("Suppression des posts terminée");
    }
}
