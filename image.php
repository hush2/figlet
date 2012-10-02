<?php
// (C) hush2 <hushywushy@gmail.com>

function generate_image($text, $font) {
    try {
        $im   = new Imagick();
        $draw = new ImagickDraw();

        //$draw->setFillColor('rgb(0,0,0)');
        $draw->setFillColor('lime');
        $draw->setFont("ttf/$font.ttf");

        $font_size = 14;
        $draw->setFontSize($font_size);

        //$pixel = new ImagickPixel('black');
        $pixel = new ImagickPixel("rgba(250,0,255,0)");

        $font_info = $im->queryFontMetrics($draw, $text );

        $width  = $font_info['textWidth'];
        $height = $font_info['textHeight'] ;

        $im->newImage($width, $height, $pixel);

        $im->annotateImage($draw, 0, $font_size, 0, $text);

        $im->setImageFormat('png');
        //$im->writeImage('debug.png');

        header("Content-Type: image/png");
        echo $im;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

session_start();
if (isset($_SESSION['text'])) {
    $text = $_SESSION['text'];
    $font = $_SESSION['font'];
} else {
    $text = "Hello, World!";
    $font = "Aurulent Sans Mono";
}

generate_image($text, $font);