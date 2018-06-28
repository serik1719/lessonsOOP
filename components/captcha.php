<?php
    header("Content-Type:image/png");

    session_start();
    
    $random = rand(10001, 99999);
    $_SESSION['captcha'] = md5($random);
    $image = imagecreatetruecolor(100, 35);
    imagefilledrectangle($image, 0, 0, 100, 35, imagecolorallocate($image, 200, 200, 200));
    //  Нужно писать так, или полный путь типа "/home/u30xxx/public_html/ ..." или как там....
    $font = '../template/resources/magikmarker.otf';
    imagettftext($image, 30, 0, 15, 23, imagecolorallocate($image, 82, 82, 82), $font, $random);
    imagegif($image);
    imagedestroy($image);
