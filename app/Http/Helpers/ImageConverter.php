<?php
namespace App\Http\Helpers;

use GdImage;

class  ImageConverter
{
    private $image;
    private $filename;
    private $imageWithPath;
    private string $path;
    private $format;
    private $data;
    private $width;
    private $height;

    private $filenameWithPath;

    public $exist = false;

    private const MEDIUMWIDTH = 800;
    public function __construct($image)
    {
        $this->image = $image;
        $this->filename = explode(".", $this->image)[0];
        $this->path = public_path("images/");

        if ( !str_contains($this->image,"images/") ) {
            $this->imageWithPath = $this->path. $this->image;
            $this->filenameWithPath = $this->path . $this->filename;
        }

        else {
            $this->imageWithPath = public_path()."/".$this->image;
            $this->filenameWithPath = public_path()."/".$this->filename;
        }

        if ( file_exists($this->imageWithPath) ) {
            $this->format = exif_imagetype($this->imageWithPath);
            $this->data = getimagesize($this->imageWithPath);
            if ( !$this->data == false ) {
                $this->width = $this->data[0];
                $this->height = $this->data[1];
                $this->exist = true;
            }

        }



    }

    private function getImage(): GdImage|null
    {
        if ($this->exist) {
            switch ($this->format) {
                case IMAGETYPE_JPEG:
                    return imagecreatefromjpeg($this->imageWithPath);
                case IMAGETYPE_PNG:
                    return imagecreatefrompng($this->imageWithPath);
                case IMAGETYPE_WEBP:
                    return imagecreatefromwebp($this->imageWithPath);
                case IMAGETYPE_AVIF:
                    return imagecreatefromavif($this->imageWithPath);
            }
        } else {
            return null;
        }
    }

    private function convertToWebp(GdImage $img,$quality = 90)
    {
        if ($this->exist) {
            $file = $this->filenameWithPath . ".webp";
            if (!file_exists($file))
                imagewebp($img, $file, $quality);
            $this->resizeImagesForThumb($img, $this->filenameWithPath, $quality, "webp");
        }
    }

    private function convertToAvif(GdImage $img,$quality = 90)
    {
        if ($this->exist){
            $file = $this->filenameWithPath . ".avif";
            if (!file_exists($file))
                imageavif($img, $file, $quality);
            $this->resizeImagesForThumb($img, $this->filenameWithPath, $quality, "avif");
        }
        return;
    }

    private function convertToJpeg(GdImage $img,$quality = 90)
    {
        if ($this->exist){
            $file = $this->filenameWithPath. ".jpeg";
            if ( !file_exists( $file ) ) {
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
                imagejpeg($img, $file, $quality);
            }
            $this->resizeImagesForThumb($img, $this->filenameWithPath, $quality,"jpeg");
        }
        return;
    }

    function convertAll(): bool
    {
        if ( $this->exist ) {
            $img = $this->getImage();
            $this->convertToWebp($img);
            $this->convertToJpeg($img);
            $this->convertToAvif($img);
            return true;
        }
        return false;
    }

    private  function resizeImage(int $new_width,int $new_height,GdImage $image):GdImage
    {
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);

        return $new_image;
    }

    private function resizeImagesForThumb(GdImage $img,string $newfile,int $quality = 90,string $format = "webp" ): void
    {
        $function = "imagewebp";
        switch ($format) {
            case "jpeg":
                $function = "imagejpeg";
                break;
            case "avif":
                $function = "imageavif";
                break;
        }

        if ( $this->width < self::MEDIUMWIDTH) {
            if ( !file_exists($newfile . "_small.".$format) ) {
                call_user_func($function, $img, $newfile . "_small." . $format, $quality);
            }
            return;
        } else {
            if ( !file_exists($newfile . "_medium.".$format))
                call_user_func($function,$this->resizeImage($this->width/2,$this->height/2,$img), $newfile . "_medium.".$format,$quality-10);
            if ( !file_exists($newfile . "_small.".$format))
                call_user_func($function,$this->resizeImage($this->width/3,$this->height/3,$img), $newfile . "_small.".$format,$quality-20);
            return;
        }

    }

}