<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait GetImage
{
    public function GetImages():array|null
    {
        if( isset($this->image_id) ) {
            $id = $this->image_id;
            $imageDb = Cache::rememberForever("modelImage_" . $this->image_id, function () use ($id) {
                return Image::where('id', $id)->first();
            });
            if ($imageDb) {

                $files = File::glob(public_path("images/" . $imageDb->name) . "*");
                if (empty($files)) {
                    return null;
                }

                if (Cache::has('image_' . $this->image_id)) {
                    return Cache::get('image_' . $this->image_id);
                }

                $images = [];
                foreach ($files as $file) {
                    $justName = explode('/', $file);
                    $extension = File::extension($file);
                    if ($extension) {
                        if (Str::contains($justName[1], 'medium')) {
                            $size = "medium";
                        } else if (Str::contains($justName[1], 'small')) {
                            $size = "small";
                        } else {
                            $size = "large";
                        }
                        $images[$extension][$size] = "images/" . end($justName);
                    }
                }
                Cache::rememberForever('image_' . $this->image_id, function () use ($images) {
                    return $images;
                });
                return $images;
            } else {
                return null;
            }
        }


    }

}