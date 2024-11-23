<?php
return [
    "maxsize" => 4094*1024,
    "maxwidth" => 1280,
    "maxheight" => 720,
    "minwidth" => 480,
    "minheight" => 320,
    "extensions" => "jpg,jpeg,png,avif,webp",
    "maxlength" => 255,
    "rulesImage" =>"mimes:jpeg,png,jpg,webp,avif|max:4096|dimensions:min_width=480,max_width=1280,min_height=320,max_height=720",
    "defaultHtmlFile" => [
        "required"=>"required","accept"=>"image/*",
        "data-extension"=>"jpg,jpeg,png,avif,webp",
        "size"=>4094*1024,
        "data-minwidth"=>480,
        "data-minheight"=>320,
        "data-maxwidth"=>1280,
        "data-maxheight"=>720,
    ]
];