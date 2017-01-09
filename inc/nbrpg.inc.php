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

  // On renvoie l'ID du perso
  if($dcheckperso = mysqli_fetch_array($checkperso))
    return $dcheckperso['id'];

  // S'il n'existe pas, on return 0
  else
    return 0;
}





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si le personnage n'est pas invité à jouer dans la session en cours
//
// Renvoie l'id de session du personnage, ou 0 si le personnage n'est pas dans la session
//
// Exemple d'utilisation:
// $id_session = nbrpg_session(nbrpg());

function nbrpg_session($id_perso)
{
  // On va chercher si le perso est dans une session
  $checksession = query(" SELECT id FROM nbrpg_session WHERE FKnbrpg_persos = '$id_perso' ");

  // On renvoie l'ID de session du perso
  if($dchecksession = mysqli_fetch_array($checksession))
    return $dchecksession['id'];

  // S'il n'est pas dans la session, on renvoie 0
  else
    return 0;
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
// Augmente une valeur en fonction d'un niveau (par exemple détermine les points de vie d'un monstre selon son niveau)
//
// $valeur est la valeur à multiplier
// $niveau est le niveau par lequel multiplier la valeur
// Utilisation: nbrpg_multiplicateur(100,5);

function nbrpg_multiplicateur($valeur,$niveau)
{
  // Le multiplicateur actuel - plus il est élevé, plus le jeu est facile
  $multiplicateur_actuel = 10;

  // Application du multiplicateur pour augmenter la difficulté linéairement avec le niveau
  $nouvelle_valeur = floor($valeur + ($valeur * (($niveau - 1) / $multiplicateur_actuel)));

  // On augmente également la difficulté exponentiellement avec le niveau
  if($niveau > 1)
    $nouvelle_valeur = floor($nouvelle_valeur * 1 + (exp ($niveau / ($multiplicateur_actuel / 3))));

  // Et on renvoie la nouvelle valeur
  return $nouvelle_valeur;
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
    $cssvie = '<span class="nbrpg_hp_high">';

  // S'ils sont pas bien, rouge et gras
  else if ($vie <= $viemax * 0.25)
    $cssvie = '<span class="nbrpg_hp_low gras">';

  // Sinon, on laisse tel quel
  else
    $cssvie = '';

  // On détermine s'il faut fermer le span ou non
  $fincssvie = ($cssvie) ? '</span>' : '';
  return $cssvie.$vie.'/'.$viemax.$fincssvie;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Calcule la valeur d'un effet après sa réduction par tour
// Par exemple, certains effets sont -25% moins efficaces chaque tour, cette fonction calcule la valeur de l'effet au tour actuel
//
// $tours_max est le nombre de tours que dure l'effet par défaut
// $tours_restants est le nombre de tours restants à l'effet au moment du calcul
// $effet est la valeur de l'effet
// $reduction est la réduction de l'effet chaque tour
// $reduction_pourcent est la réduction en pourcentages de l'effet chaque tour
// Utilisation : nbrpg_reduction_effet(5,3,10,-1,10);

function nbrpg_reduction_effet($tours_max,$tours_restants,$effet,$reduction,$reduction_pourcent)
{
  // On commence par calculer combien de tours de réduction à appliquer
  $reduction_tours = $tours_max - $tours_restants;

  // On applique la réduction de l'effet et on en retourne le résultat
  return ($effet - ($reduction * $reduction_tours)) * (1 - ($reduction_tours * $reduction_pourcent / 100));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Calcule une valeur après l'application d'un effet dessus
// Par exemple, permet d'avoir les points de vie max d'un personnage dont les points de vie max sont réduits par un effet
//
// $valeur est la valeur à recalculer
// $effet est l'effet appliqué sur la valeur
// $effet_pourcentage est l'effet appliqué en pourcentage sur la valeur
// Utilisation : nbrpg_application_effet(10,-1,10);

function nbrpg_application_effet($valeur,$effet,$effet_pourcentage)
{
  // On applique l'effet sur la valeur
  $valeur = ($valeur + $effet) * (1 + ($effet_pourcentage / 100));

  // On s'assure que la valeur ne soit jamais inférieure à 1
  if($valeur <= 1)
    $valeur = 1;

  // Et on renvoie la valeur
  return floor($valeur);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prépare un effet pour l'affichage sous forme de bouton avec tooltip, renvoie un bloc de HTML dans un <span>
//
// $effet est l'id de l'effet dans la table nbrpg_effets de la base de données
// $duree est la durée actuellement restante à l'effet (donnée à la fonction pour ne pas avoir à aller piocher dans nbrpg_session)
// Utilisation : nbrpg_format_effet(69,4);

function nbrpg_format_effet($effet,$duree)
{
  // On va chercher des infos sur l'effet
  $qeffets  = query(" SELECT  nbrpg_effets.url_icone                          AS 'e_icone'      ,
                              nbrpg_effets.nom                                AS 'e_nom'        ,
                              nbrpg_effets.description                        AS 'e_desc'       ,
                              nbrpg_effets.paralysie                          AS 'e_para'       ,
                              nbrpg_effets.degats                             AS 'e_dmg'        ,
                              nbrpg_effets.buff_degats                        AS 'e_degats'     ,
                              nbrpg_effets.buff_degats_pourcent               AS 'e_degatsp'    ,
                              nbrpg_effets.buff_hpmax                         AS 'e_hpmax'      ,
                              nbrpg_effets.buff_hpmax_pourcent                AS 'e_hpmaxp'     ,
                              nbrpg_effets.buff_danger                        AS 'e_danger'     ,
                              nbrpg_effets.buff_danger_pourcent               AS 'e_dangerp'    ,
                              nbrpg_effets.buff_physique                      AS 'e_physique'   ,
                              nbrpg_effets.buff_physique_pourcent             AS 'e_physiquep'  ,
                              nbrpg_effets.buff_mental                        AS 'e_mental'     ,
                              nbrpg_effets.buff_mental_pourcent               AS 'e_mentalp'    ,
                              nbrpg_effets.reduction_degats                   AS 'e_reduction'  ,
                              nbrpg_effets.reduction_degats_pourcent          AS 'e_reductionp' ,
                              nbrpg_effets.ne_peut_pas_tuer                   AS 'e_nppt'       ,
                              nbrpg_effets.ne_peut_pas_etre_debuff            AS 'e_npped'      ,
                              nbrpg_effets.reduction_effet_par_tour           AS 'e_reduc'      ,
                              nbrpg_effets.reduction_effet_par_tour_pourcent  AS 'e_reducp'     ,
                              nbrpg_effets.flavortext                         AS 'e_flavor'
                      FROM    nbrpg_effets
                      WHERE   nbrpg_effets.id = '$effet' ");

  // On prépare les infos nécessaires
  $deffets  = mysqli_fetch_array($qeffets);
  $e_icone  = $deffets['e_icone'];
  $e_nom    = $deffets['e_nom'];
  $e_duree  = ($duree > 1) ? 'tours restants' : 'tour restant';
  $e_desc   = $deffets['e_desc'];
  $e_effets = '';

  // Effets positifs
  $e_effets .= ($deffets['e_dmg'] < 0) ? "<p class=\"nbrpg_hp_high gras\">+".abs($deffets['e_dmg'])." HP par tour</p>" : '';
  $e_effets .= ($deffets['e_degats'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_degats']." à la puissance d'attaque</p>" : '';
  $e_effets .= ($deffets['e_degatsp'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_degatsp']."% à la puissance d'attaque</p>" : '';
  $e_effets .= ($deffets['e_hpmax'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_hpmax']." HP maximum</p>" : '';
  $e_effets .= ($deffets['e_hpmaxp'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_hpmaxp']."% HP maximum</p>" : '';
  $e_effets .= ($deffets['e_danger'] < 0) ? "<p class=\"nbrpg_hp_high gras\">".$deffets['e_danger']." niveau de danger</p>" : '';
  $e_effets .= ($deffets['e_dangerp'] < 0) ? "<p class=\"nbrpg_hp_high gras\">".$deffets['e_dangerp']."% niveau de danger</p>" : '';
  $e_effets .= ($deffets['e_physique'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_physique']." physique</p>" : '';
  $e_effets .= ($deffets['e_physiquep'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_physiquep']."% physique</p>" : '';
  $e_effets .= ($deffets['e_mental'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_mental']." mental</p>" : '';
  $e_effets .= ($deffets['e_mentalp'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_mentalp']."% mental</p>" : '';
  $e_effets .= ($deffets['e_reduction'] > 0) ? "<p class=\"nbrpg_hp_high gras\">Dégâts subis réduits de ".$deffets['e_reduction']."</p>" : '';
  $e_effets .= ($deffets['e_reductionp'] > 0) ? "<p class=\"nbrpg_hp_high gras\">Dégâts subis réduits de ".$deffets['e_reductionp']."%</p>" : '';

  // Effets négatifs
  $e_effets .= ($deffets['e_nppt']) ? "<p class=\"nbrpg_hp_low gras\">Empêche toute action</p>" : '';
  $e_effets .= ($deffets['e_dmg'] > 0) ? "<p class=\"nbrpg_hp_low gras\">-".$deffets['e_dmg']." HP par tour</p>" : '';
  $e_effets .= ($deffets['e_degats'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_degats']." à la puissance d'attaque</p>" : '';
  $e_effets .= ($deffets['e_degatsp'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_degatsp']."% à la puissance d'attaque</p>" : '';
  $e_effets .= ($deffets['e_hpmax'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_hpmax']." HP maximum</p>" : '';
  $e_effets .= ($deffets['e_hpmaxp'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_hpmaxp']."% HP maximum</p>" : '';
  $e_effets .= ($deffets['e_danger'] > 0) ? "<p class=\"nbrpg_hp_low gras\">+".$deffets['e_danger']." niveau de danger</p>" : '';
  $e_effets .= ($deffets['e_dangerp'] > 0) ? "<p class=\"nbrpg_hp_low gras\">+".$deffets['e_dangerp']."% niveau de danger</p>" : '';
  $e_effets .= ($deffets['e_physique'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_physique']." physique</p>" : '';
  $e_effets .= ($deffets['e_physiquep'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_physiquep']."% physique</p>" : '';
  $e_effets .= ($deffets['e_mental'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_mental']." mental</p>" : '';
  $e_effets .= ($deffets['e_mentalp'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_mentalp']."% mental</p>" : '';
  $e_effets .= ($deffets['e_reduction'] < 0) ? "<p class=\"nbrpg_hp_low gras\">Dégâts subis augmentés de ".abs($deffets['e_reduction'])."</p>" : '';
  $e_effets .= ($deffets['e_reductionp'] < 0) ? "<p class=\"nbrpg_hp_low gras\">Dégâts subis augmentés de ".abs($deffets['e_reductionp'])."%</p>" : '';

  // Effets spéciaux
  $e_effets .= ($deffets['e_nppt']) ? "<p class=\"gras\">Ne peut pas tuer la cible</p>" : '';
  $e_effets .= ($deffets['e_npped']) ? "<p class=\"gras\">Impossible de retirer cet effet</p>" : '';
  $e_effets .= ($deffets['e_reduc'] > 0) ? "<p class=\"gras\">L'effet baisse de ".$deffets['e_reduc']." chaque tour</p>" : '';
  $e_effets .= ($deffets['e_reduc'] < 0) ? "<p class=\"gras\">L'effet augmente de ".abs($deffets['e_reduc'])." chaque tour</p>" : '';
  $e_effets .= ($deffets['e_reducp'] > 0) ? "<p class=\"gras\">L'effet baisse de ".$deffets['e_reducp']."% chaque tour</p>" : '';
  $e_effets .= ($deffets['e_reducp'] < 0) ? "<p class=\"gras\">L'effet augmente de ".abs($deffets['e_reducp'])."% chaque tour</p>" : '';

  // Fin de préparation des infos
  $e_effets = ($e_effets) ? "<hr class=\"points\">".$e_effets : '';
  $e_flavor = ($deffets['e_flavor']) ? "<hr class=\"points\"><p class=\"italique\">".$deffets['e_flavor']."</p>": '';

  // Et on renvoie une version formattée de l'effet
  return "<span class=\"pointeur tooltip\">
            <img src=\"./../../img/nbrpg/$e_icone\" alt=\"X\" style=\"border:1px solid #000000;border-radius:4px\">
            <div class=\"petittooltip\">
              <p class=\"indiv align_center gras majuscules\">$e_nom</p>
              <p class=\"indiv align_center\"><span class=\"gras\">$duree</span> $e_duree</p>
              <hr class=\"points\">
              <p>$e_desc</p>
              $e_effets
              $e_flavor
            </div>
          </span>";
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