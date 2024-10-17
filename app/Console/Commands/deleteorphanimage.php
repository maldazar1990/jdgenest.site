<?php

namespace App\Console\Commands;

use App\HelperGeneral;
use App\Infos;
use App\post;
use App\Users;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class deleteorphanimage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteorphanimage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'supprime les images sans postes ni infos ni users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = public_path('images');
        $files = \File::files($path);
        foreach($files as $file){
            $filename = $file->getFilename();
            $filename = explode(".", $filename);
            HelperGeneral::deleteImage($filename);
        }
        return Command::SUCCESS;
    }
}
