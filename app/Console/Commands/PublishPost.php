<?php

namespace App\Console\Commands;

use App\post;
use Illuminate\Console\Command;

class PublishPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:publishport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'met en ligne les articles avec un status pending';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach(post::where("status",1)->get() as $post){
            $post->status = 0;
            $post->save();
        }
        return Command::SUCCESS;
    }
}
