<?php

namespace App\Console\Commands;

use App\HelperGeneral;
use App\Image as Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddImage2BDD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:image2bdd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ajoute les images dans la bdd';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $images = HelperGeneral::getImages();
        foreach($images as $name => $image){
            if (DB::table('image')->where('name', $name)->doesntExist()) {
                $newImage = new Image();
                $newImage->name = $name;
                $newImage->file = $image;
                $newImage->save();
            }
        }

        return Command::SUCCESS;
    }
}
