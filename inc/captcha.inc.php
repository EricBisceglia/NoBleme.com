<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                   //
//                                 This page generates a captcha image when included                                 //
//     A random string of 6 numbers is randomly generated and placed in the session variable $_SESSION['catcha']     //
//                    You should directly call it from HTML, eg. <img src="/inc/captcha.inc.php">                    //
//                                                                                                                   //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// First off, open the current session for this, since it's going to be included separately
session_name('nobleme_session');
session_start();
session_regenerate_id();

// Generate the random numbers
$captcha_rand = rand(100000, 999999);

// Place them in a session variable
$_SESSION['captcha'] = $captcha_rand;

// Prepare the properties of the image
$captcha_image      = imagecreate(120, 40);
$captcha_background = imagecolorallocate($captcha_image, 18, 18, 18);
$captcha_text_color = imagecolorallocate($captcha_image, 127, 157, 177);

// Assemble the image
imagettftext($captcha_image, 20, 0, 10, 25, $captcha_text_color, './../css/fonts/Open-sans.ttf', $captcha_rand);

// Send a header with an expilation date in the past to disable browser caching
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");

// More HTTP headers to ensure there is no caching going on
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// The image won't display without this header
header('Content-type: image/jpeg');

// Print the image
imagejpeg($captcha_image);

// Destroy the image right away, no point keeping it in memory
imagedestroy($captcha_image);