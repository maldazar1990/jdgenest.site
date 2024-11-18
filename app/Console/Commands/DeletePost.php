<?php

namespace App\Console\Commands;

use App\post;
use Illuminate\Console\Command;

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
            $post->delete();
        }
        \Log::info("Suppression des posts terminée");
    }
}
