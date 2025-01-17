<?php
$sizeinKo = 2048;
$maxsize = $sizeinKo*1024;
$maxwidth = 1920;
$maxheight = 1080;
$minwidth = 720;
$minheight = 480;
$extensions = "jpg,jpeg,png,avif,webp";

$extensionsArray = explode(",",$extensions);
foreach($extensionsArray as $key => $extension){
    $extensionsArray[$key] = ".".$extension;
}
$extensionInputValidation = implode(",",$extensionsArray);

return [
    "default" => "images/default.webp",
    "maxsize" => $maxsize,
    "max_convert_size" => 10240,
    "maxwidth" => $maxwidth,
    "maxheight" => $maxheight,
    "minwidth" => $minwidth,
    "minheight" => $minheight,
    "extensions" => $extensions,
    "maxlength" => 255,
    "rulesImage" =>"mimes:".$extensions."|max:".$sizeinKo."|dimensions:min_width=".$minwidth.",max_width=".$maxwidth.",min_height=".$minheight.",max_height=".$maxheight,
    "defaultHtmlFile" => [
        "required"=>"required",
        "accept"=>$extensionInputValidation,
        "size"=>$maxsize,
        "data-minwidth"=>$minwidth,
        "data-minheight"=>$minheight,
        "data-maxwidth"=>$maxwidth,
        "data-maxheight"=>$maxheight,
    ]
];