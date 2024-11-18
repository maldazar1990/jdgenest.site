<?php

namespace App\Console\Commands;

use App\Http\Helpers\ImageConverter;
use App\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ConvertImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-image';

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
        Log::info("images convert start");
        foreach(Image::where("migrated",false)->get() as $imageRecord){
            $image = $imageRecord->file;
            Log::info($image);
            $filename = explode('.', $image);
            if ($filename[1] != ".svg") {
                $img = new ImageConverter($image);
                if ( $img->exist == true ){
                    Log::info("image convert convertion");
                    if (!$img->convertAll()) {
                        Log::info("image convert convertion failed");
                        return ;
                    } else {
                        Log::info("image convert convertion end");

                        $image = $filename[0] . ".webp";
                        Log::info($image);
                        $imageRecord->file = $image;
                        $imageRecord->migrated = true;
                        $imageRecord->save();
                        Log::info("image convert end");
                    }

                } else {
                    Log::info("image not exist");
                }
            } else {
                LOG::info("image is svg");
                $imageRecord->migrated = true;
                $imageRecord->save();
            }
        }
    }
}
