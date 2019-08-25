<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                   //
//                                 This page generates a captcha image when included                                 //
//     A random string of 6 numbers is randomly generated and placed in the session variable $_SESSION['catcha']     //
//                    You should directly call it from HTML, eg. <img src="/inc/captcha.inc.php">                    //
//                                                                                                                   //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// First off, open a new session for this, since it's included separately
include './configuration.inc.php';
include './sanitization.inc.php';
include './sql.inc.php';
include './users.inc.php';
secure_session_start();

// Generate the random numbers
$rand = rand(100000, 999999);

// Place them in a session variable
$_SESSION['captcha'] = $rand;

// Prepare the properties of the image
$image      = imagecreate(65, 30);
$text_color = imagecolorallocate($image, 127, 157, 177);

// Assemble the image
imagestring($image, 5, 5, 8, $rand, $text_color);

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
imagejpeg($image);

// Destroy it right away, because we're mean spirited people (or alternatively to free up memory)
imagedestroy($image);