<?php

session_start();
header ('Content-type: image/png');

$chars = "012345678901234567abcdefghijklmnopqrstuvwxyz
ABCDEFGHIJKLMNOPQRSTUVWXYZ";

$captcha_text = '';
 
for ($i = 0; $i < 6; $i++) 
{
    $captcha_text .= $chars[rand(0, strlen($chars)-1)];
}	

$captcha_bg = @imagecreatefrompng("captcha.png"); 
	
imagettftext( $captcha_bg, 30, 0, 0, 40, imagecolorallocate ($captcha_bg, 0, 0, 0),
 'larabiefont.ttf', $captcha_text );

$_SESSION['captcha'] = $captcha_text;

imagepng($captcha_bg, NULL, 0);
imagedestroy($captcha_bg);

?>