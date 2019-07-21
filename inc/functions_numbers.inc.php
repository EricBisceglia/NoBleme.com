<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie un nombre avec le bon signe
//
// Exemple d'utilisation :
// $nombre_signed = signe_nombre($nombre)

function signe_nombre($nombre)
{
  if($nombre > 0)
    return '+'.$nombre;
  else
    return $nombre;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie un style css en fonction d'un contenu selon s'il est positif, neutre, ou négatif
// Si $hex est rempli, renvoie un hex de couleur au lieu d'une classe css
//
// Exemple d'utilisation :
// $couleur_contenu = format_positif($contenu);

function format_positif($contenu,$hex=NULL)
{
  if(!$hex)
  {
    if($contenu > 0)
      return 'positif';
    else if($contenu == 0)
      return 'neutre';
    else
      return 'negatif';
  }
  else
  {
    if($contenu > 0)
      return '339966';
    else if($contenu == 0)
      return 'EB8933';
    else
      return 'FF0000';
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Formatte un nombre selon plusieurs formats possibles
// $nombre est le nombre à formatter
// $format est le type de format à y appliquer
// Si $decimales est précisé, affiche ce nombre de décimales après la virgule (lorsque c'est possible)
// Si $signe est précisé, affiche le signe + si le nombre est positif
//
// Exemple d'utilisation :
// $prix = format_nombre($nombre,"prix")

function format_nombre($nombre,$format,$decimales=NULL,$signe=NULL)
{
  // Nombre de décimales (en option) pour les pourcentages et les points
  $decimales = (!is_null($decimales)) ? $decimales : 1;

  // Formater un prix
  if($format == "nombre")
    $format_nombre = number_format((float)$nombre, 0, ',', ' ');

  // Formater un prix
  if($format == "prix")
    $format_nombre = number_format((float)$nombre, 0, ',', ' ')." €";

  // Formater un prix avec centimes
  if($format == "centimes")
    $format_nombre = number_format((float)$nombre, 2, ',', ' ')." €";

  // Formater un pourcentage
  else if($format == "pourcentage")
    $format_nombre = number_format((float)$nombre, $decimales, ',', '')." %";

  // Formater un point de pourcentage
  else if($format == "point")
    $format_nombre = number_format((float)$nombre, $decimales, ',', '')." p%";

  // Application du signe si nécessaire
  if($signe && $nombre > 0)
    $format_nombre = '+'.$format_nombre;

  // On renvoie le résultat
  return $format_nombre;
}