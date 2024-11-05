<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

define('PATHIMAGE',$path = \public_path("images/"));

class HelperGeneral {
     
    static function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
    public static function urlValide($url){
        $headers = @get_headers($url);
        if(strpos($headers[0],'200')===false)return false;
        return true;
    }

    static function wordToMinute($text){
        return round(str_word_count($text)/200);
    }
}
