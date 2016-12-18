<?php
require 'ThumbnailImage.php';
$path = $_GET['path'];
$maxsize = $_GET['size'];

if (!isset($maxsize)) {
    $maxsize = 100;
}

if (isset($path)) {
    $thumb = new ThumbnailImage($path,$maxsize);
    $thumb->getImage();
}

//$im = imageCreateFromPNG($path);
//Header("Content-type: image/png");
//imagePNG($im);
