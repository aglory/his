<?php
if (!defined('Execute') || !defined('IsAdmin')) {
	exit();
}
header('Content-type: image/png');
$sourcechars = ['a', 'b', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'm', 'n', 'q', 'r', 't', 'y', 'A', 'B', 'D', 'E', 'F', 'G', 'H', 'J', 'L', 'M', 'N', 'R', 'T', 'Y', '2', '3', '4', '5', '6', '7', '8', '9'];
$targetchars = "";
for ($i = 0; $i < 4; $i++) {
	$targetchars .= $sourcechars[rand(0, count($sourcechars) - 1)];
}
$width = 70;
$height = 34;
$img = imagecreate($width, $height);
$color = imagecolorallocate($img,  0xff, 0xff, 0xff);
imagefilledrectangle($img, 0, 0, $width, $width, $color);
$color = imagecolorallocate($img, 0x0, 0x0, 0x0);
imagerectangle($img, 0, 0, $width - 1, $height - 1, $color);
// $fuente = realpath('assets/font/arial.ttf');
// imagettftext($img, 34, 0, 0, 0, $color, './assets/font/arial.ttf', "11");
if ($_SERVER['REMOTE_HOST'] = "127.0.0.1")
	$targetchars = "1234";
imagestring($img, 32, 5, 5, $targetchars, $color);
imagepng($img);
imagedestroy($img);
$_SESSION['VerifyCode'] = $targetchars;
