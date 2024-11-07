<?php

namespace App\Jobs;

use App\HelperGeneral;
use App\Http\Helpers\ImageConverter;
use App\post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ConvertImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $image,$model;
    /**
     * Create a new job instance.
     */
    public function __construct( string $image,Model $model)
    {
        Log::info("instanciation convertion");
        $this->image = $image;
        $this->model = $model;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("image convert start");
        Log::info($this->image);
        $filename = explode('.', $this->image);
        if ($filename[1] != ".svg") {
            $img = new ImageConverter($this->image);
            Log::info("image convert convertion");
            $img->convertAll();
            Log::info("image convert convertion end");

            $image = $filename[0] . ".webp";
            Log::info($image);
            $this->model->image = $image;
            $this->model->save();
            Log::info("image convert end");
        } else {
            LOG::info("image is svg");
        }
    }
}
