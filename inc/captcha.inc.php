<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                   //
//                                 This page generates a captcha image when included                                 //
//     A random string of 6 numbers is randomly generated and placed in the session variable $_SESSION['catcha']     //
//                    You should directly call it from HTML, eg. <img src="/inc/captcha.inc.php">                    //
//                                                                                                                   //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// First off, we need to open a new session for this, since it's included separately
include './configuration.inc.php';
include './sanitization.inc.php';
include './sql.inc.php';
include './users.inc.php';
secure_session_start();

// We generate the random numbers
$rand = rand(100000, 999999);

// We place them in a session variable
$_SESSION['captcha'] = $rand;

// We prepare the properties of the image
$image      = imagecreate(65, 30);
$text_color = imagecolorallocate($image, 127, 157, 177);

// We assemble the image
imagestring($image, 5, 5, 8, $rand, $text_color);

// We send a header with an expilation date in the past to disable browser caching
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");

// More HTTP headers to ensure there is no caching going on
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// If we don't send this header then the image won't display
header('Content-type: image/jpeg');

// Now we can print the image
imagejpeg($image);

// And we destroy it right away, because we're mean spirited people (or just because we want to free up memory)
imagedestroy($image);