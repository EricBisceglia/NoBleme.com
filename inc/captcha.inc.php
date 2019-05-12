<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Cette page génère une image de type captcha lorsqu'elle est appelée.
// Un nombre à 6 chiffres est aléatoirement généré et placé dans la variable de session $_SESSION['captcha']
//
// Exemple d'utilisation: <img src="/inc/captcha.inc.php">


// On commence par ouvrir la session
include 'session.inc.php';
session_start_securise();

// Définition d'une valeur aléatoire
$rand = rand(100000, 999999);

// Mise en session de la valeur aléatoire
$_SESSION['captcha'] = $rand;

// Création de l'image
$image = imagecreate(65, 30);
$bgColor = imagecolorallocate ($image, 233, 233, 233);
$textColor = imagecolorallocate ($image, 127, 157, 177);
imagestring ($image, 5, 5, 8, $rand, $textColor);

// Header toujours modifié, avec une date dans le passé
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
header("Pragma: no-cache");

// Envoyer le bon header pour que l'image s'affiche
header('Content-type: image/jpeg');

// Affichage de l'image
imagejpeg($image);

// Suppression de l'image, fin du script
imagedestroy($image);