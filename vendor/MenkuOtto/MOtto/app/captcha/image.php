<?php
session_start();
header("Content-type: image/png");
include 'captcha.php';
$image=new app\captcha\Captcha();
$image->setSession();
//echo $_SESSION['_CAPTCHA']['code'];
$captcha=$image->getImage($_SESSION['CAPTCHA']);
imagepng($captcha);