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
            if (Cache::has('images_' . $this->image_id)) {
                return Cache::get('images_' . $this->image_id);
            }
            $id = $this->image_id;
            $imageDb = Cache::rememberForever("modelImage_" . $this->image_id, function () use ($id) {
                return Image::where('id', $id)->first();
            });
            if ($imageDb) {

                $files = File::glob(public_path("images/" . $imageDb->name) . "*");
                if (empty($files)) {
                    return null;
                }

                $images = [];
                foreach ($files as $file) {
                    $justName = explode('/', $file);
                    $extension = File::extension($file);
                    if ($extension) {
                        if (Str::contains(end($justName), 'medium')) {
                            $size = "medium";
                        } else if (Str::contains(end($justName), 'small')) {
                            $size = "small";
                        } else {
                            $size = "large";
                        }
                        $images[$extension][$size] = "images/" . end($justName);
                    }
                }
                Cache::rememberForever('images_' . $this->image_id, function () use ($images) {
                    return $images;
                });
                return $images;
            } else {
                return null;
            }
        }
        return null;
    }

}