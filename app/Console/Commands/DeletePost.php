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
    protected $signature = 'command:deletepost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'supprime les postes avec un status deleted';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        post::where("status",2)->delete();
        return Command::SUCCESS;
    }
}
