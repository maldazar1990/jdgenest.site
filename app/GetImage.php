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
            if ($this->created_at < now()->subDay()) {
                $files = File::glob(public_path("images/" . $this->name) . "*");
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

                return $images;
            }
            
            return Cache::remember('images_' . $this->image_id, 60*60*24 , function () use ($id) {
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

                    return $images;
                } else {
                    return null;
                }
            });
        }
        return null;
    }

    public function GetBasicImage():string|null
    {
        if( isset($this->image_id) ) {
            $id = $this->image_id;
            return Cache::rememberForever('basic_image_' . $this->image_id, function () use ($id) {
                $imageDb = Cache::rememberForever("modelImage_" . $this->image_id, function () use ($id) {
                    return Image::where('id', $id)->first();
                });
                if ($imageDb) {

                    $files = File::glob(public_path("images/" . $imageDb->name) . "*.webp");
                    if (empty($files)) {
                        return  config("custom.default");
                    }

                    $image = config("custom.default");
                    foreach ($files as $file) {
                        $justName = explode('/', $file);
                        $image = "images/" . end($justName);
                        break;
                    }

                    return $image;
                } else {
                    return  config("custom.default");
                }
            });
        }
        return  config("custom.default");
    }

}