<?php

namespace App\Console\Commands;

use App\Http\Helpers\ImageConverter;
use App\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
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
        foreach(Image::where("migrated",false)->get() as $imageRecord) {
            $image = $imageRecord->file;
            Log::info($image);
            $filename = explode('.', $image);

            $path = public_path("images/");

            if ( !str_contains($image,"images/") ) {
                $imageWithPath = $path. $image;
            }

            else {
                $imageWithPath = public_path()."/".$image;
            }

            $extension = "";
            if (!isset($filename[1])) {

                $format = mime_content_type( $imageWithPath);
                switch ($format) {
                    case "image/jpeg":
                        $imageRecord->file = $filename[0] . ".jpg";

                        $imageRecord->save();
                        $extension = ".jpg";
                        break;
                    case "image/png":
                        $imageRecord->file = $filename[0] . ".png";
                        $imageRecord->save();
                        $extension = ".png";
                        break;
                    case "image/gif":
                        $imageRecord->file = $filename[0] . ".gif";
                        $imageRecord->save();
                        $extension = ".gif";
                        break;
                    case "image/webp":
                        $imageRecord->file = $filename[0] . ".webp";
                        $imageRecord->save();
                        $extension = ".webp";
                        break;
                    case "image/avif":
                        $imageRecord->file = $filename[0] . ".avif";
                        $imageRecord->save();
                        $extension = ".avif";
                        break;
                    case "image/svg+xml":
                        $imageRecord->file = $filename[0] . ".svg";
                        $imageRecord->save();
                        $extension = ".svg";
                        break;
                    default:
                        Log::info("image format not supported");
                        break;
                }

                if ($extension)
                    File::move($imageWithPath, $path . $filename[0] . $extension);

            } else {
                $extension = "." . $filename[1];
            }

            if ($extension=="") {
                Log::info("image format not supported");
                continue;
            }

            if ($extension != ".svg") {
                $img = new ImageConverter($image);
                if ($img->exist == true) {
                    Log::info("image convert convertion");
                    if (!$img->convertAll()) {
                        Log::info("image convert convertion failed");
                        return;
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
