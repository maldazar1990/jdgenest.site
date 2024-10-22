<?php

namespace App\Jobs;

use App\HelperGeneral;
use App\post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConvertImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $image,$idPost;
    /**
     * Create a new job instance.
     */
    public function __construct( $image,$idPost)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        HelperGeneral::createNewImage($this->image);
        $filename = explode('.', $this->image);
        $image = $filename[0].".webp";

        $post = post::find($this->idPost);
        $post->image = $image;
        $post->save();
    }
}
