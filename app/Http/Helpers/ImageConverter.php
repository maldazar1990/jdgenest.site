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

    private const MEDIUMWIDTH = 767;
    private const LARGEWIDTH = 1280;
    public function __construct($image)
    {
        $this->image = $image;
        $this->filename = explode(".", $this->image)[0];
        $this->path = public_path("images/");
        $this->imageWithPath = $this->path. $this->image;

        $this->format = exif_imagetype($this->imageWithPath);
        $this->data = getimagesize($this->imageWithPath);
        $this->width = $this->data[0];
        $this->height = $this->data[1];
    }

    private function getImage(): GdImage
    {
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
    }

    private function convertToWebp(GdImage $img,$quality = 90)
    {
        imagewebp($img, \public_path("images/") . $this->filename . ".webp", $quality);
        $this->resizeImagesForThumb($img, \public_path("images/") . $this->filename, $quality, "webp");
    }

    private function convertToAvif(GdImage $img,$quality = 90)
    {
        imageavif($img, \public_path("images/") . $this->filename . ".avif", $quality);
        $this->resizeImagesForThumb($img, \public_path("images/") . $this->filename, $quality, "avif");
    }

    private function convertToJpeg(GdImage $img,$quality = 90)
    {
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        imagejpeg($img, \public_path("images/") . $this->filename . ".jpeg", $quality);
        $this->resizeImagesForThumb($img, \public_path("images/") . $this->filename, $quality,"jpeg");
    }

    function convertAll(): void
    {
        $img = $this->getImage();
        $this->convertToWebp($img);
        $this->convertToJpeg($img);
        $this->convertToAvif($img);
    
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
            call_user_func($function,$img, $newfile . "_small.".$format,$quality);
            return;
        } else {
            call_user_func($function,$this->resizeImage($this->width/2,$this->height/2,$img), $newfile . "_medium.".$format,$quality-10);
            call_user_func($function,$this->resizeImage($this->width/3,$this->height/3,$img), $newfile . "_small.".$format,$quality-20);
            return;
        }

    }

}