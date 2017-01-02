<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si l'utilisateur n'a pas de personnage crée dans le NBRPG
//
// Renvoie l'id du personnage appartenant au joueur, ou 0 si le joueur n'existe pas
//
// Exemple d'utilisation:
// $id_perso = nbrpg();

function nbrpg()
{
  // On rejette les invités en renvoyant 0
  if(!loggedin())
    return 0;

  // On va chercher si le joueur a un personnage
  $checkuser  = $_SESSION['user'];
  $checkperso = query(" SELECT id FROM nbrpg_persos WHERE FKmembres = '$checkuser' ");

  // S'il n'existe pas, on return 0
  if(!mysqli_num_rows($checkperso))
    return 0;

  // Sinon, on renvoie son ID
  else
  {
    $dcheckperso = mysqli_fetch_array($checkperso);
    return $dcheckperso['id'];
  }
}





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction assignant une couleur aléatoire à un nouveau compte
//
// Exemple d'utilisation:
// $rand_couleur = nbrpg_couleur();

function nbrpg_couleur()
{
  return '#'.dechex(rand(0,120)+40).dechex(rand(0,120)+40).dechex(rand(0,120)+40);
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Formatte une ligne de chat pour qu'ils aient une apparence standard
//
// $timestamp est le timestamp auquel le message a été posté
// $couleur est la couleur associée à l'auteur du message
// $nom est le personnage de l'auteur du message
// $type est le type de message (RP, HRP, etc)
// $message est le contenu du message
// Utilisation: nbrpg_chatlog(1337,'Bad','RP','Bonjour les [b]enfants[/b]');

function nbrpg_chatlog($timestamp,$couleur,$nom,$type,$message)
{
  // On définit l'apparence du message
  $css = ($type == 'narrateur') ? 'class="gras"' : 'style="color:'.$couleur.'"';

  // On prépare pour l'affichage
  $date = date('H:i',$timestamp);

  // Puis on balance le message
  return '<p '.$css.'>'.$date.' <span class="gras">'.$nom.' :</span> '.$message.'</p>';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Affiche les points de vie d'un personnage ou monstre, en vert si ça va bien et en rouge si ça va pas
//
// $vie est les points de vie actuels
// $viemax est les poinst de vie max du personnage ou monstre
// Utilisation: nbrpg_vierestante(10,25);

function nbrpg_vierestante($vie,$viemax)
{
  // Si les points de vie sont bien, on met en vert
  if($vie >= $viemax * 0.75)
    $cssvie = '<span style="color:#008000;">';
  // S'ils sont pas bien, rouge et gras
  else if ($vie <= $viemax * 0.25)
    $cssvie = '<span style="color:#B22222;font-weight:bold;">';
  // Sinon, on laisse tel quel
  else
    $cssvie = '';

  // On détermine s'il faut fermer le span ou non
  $fincssvie = ($cssvie) ? '</span>' : '';
  return $cssvie.$vie.'/'.$viemax.$fincssvie;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifie les points de vie d'une cible
//
// $cible est l'id de session d'un joueur ou monstre actuellement présent dans une session active
// $valeur est un nombre positif ou négatif
// Utilisation: nbrpg_edithp(2,-4);

function nbrpg_edithp($cible,$valeur)
{
  query(" UPDATE nbrpg_session SET vie = (vie + $valeur) WHERE id = $cible ");
}

