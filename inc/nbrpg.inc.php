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
// Exemple d'Utilisation :
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
// Exemple d'Utilisation :
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
// Exemple d'Utilisation :
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
// Utilisation : nbrpg_chatlog(1337,nbrpg_couleur(),'Bad','RP','Bonjour les [b]enfants[/b]');

function nbrpg_chatlog($timestamp,$couleur,$nom,$type,$message)
{
  // On définit l'apparence du message
  $css = ($type == 'narrateur') ? 'class="gras" style="padding:0px"' : 'style="color:'.$couleur.';padding:0px"';

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
// Utilisation : nbrpg_multiplicateur(100,5);

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
// Utilisation : nbrpg_vierestante(10,25);

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
  // Si c'est un buff à durée infinie, on ne fait pas le calcul
  if(!$tours_restants)
    return $effet;

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
                              nbrpg_effets.buff_precision                     AS 'e_precision'  ,
                              nbrpg_effets.buff_degats                        AS 'e_degats'     ,
                              nbrpg_effets.buff_degats_pourcent               AS 'e_degatsp'    ,
                              nbrpg_effets.amplification_soins                AS 'e_asoins'     ,
                              nbrpg_effets.amplification_soins_pourcent       AS 'e_asoinsp'    ,
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
                              nbrpg_effets.amplification_soins_recus          AS 'e_asoinsr'    ,
                              nbrpg_effets.amplification_soins_recus_pourcent AS 'e_asoinsrp'   ,
                              nbrpg_effets.ne_peut_pas_tuer                   AS 'e_nppt'       ,
                              nbrpg_effets.ne_peut_pas_etre_debuff            AS 'e_npped'      ,
                              nbrpg_effets.reduction_effet_par_tour           AS 'e_reduc'      ,
                              nbrpg_effets.reduction_effet_par_tour_pourcent  AS 'e_reducp'     ,
                              nbrpg_effets.flavortext                         AS 'e_flavor'
                      FROM    nbrpg_effets
                      WHERE   nbrpg_effets.id = '$effet' ");

  if(!mysqli_num_rows($qeffets))
    return NULL;

  // On prépare les infos nécessaires
  $deffets  = mysqli_fetch_array($qeffets);
  $e_icone  = $deffets['e_icone'];
  $e_nom    = $deffets['e_nom'];
  $e_durees = ($duree > 1) ? 'tours restants' : 'tour restant';
  $e_dureet = ($duree > 0) ? "<span class=\"gras\">$duree</span> $e_durees" : 'Durée infinie';
  $e_duree  = "<p class=\"indiv align_center\">$e_dureet</p>";
  $e_desc   = $deffets['e_desc'];
  $e_effets = '';

  // Effets positifs
  $e_effets .= ($deffets['e_dmg'] < 0) ? "<p class=\"nbrpg_hp_high gras\">+".abs($deffets['e_dmg'])." HP par tour</p>" : '';
  $e_effets .= ($deffets['e_precision'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_precision']."% à la précision des attaques</p>" : '';
  $e_effets .= ($deffets['e_degats'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_degats']." à la puissance d'attaque</p>" : '';
  $e_effets .= ($deffets['e_degatsp'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_degatsp']."% à la puissance d'attaque</p>" : '';
  $e_effets .= ($deffets['e_asoins'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_asoins']." à l'efficacité des soins</p>" : '';
  $e_effets .= ($deffets['e_asoinsp'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_asoinsp']."% à l'efficacité des soins</p>" : '';
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
  $e_effets .= ($deffets['e_asoinsr'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_asoinsr']." à l'efficacité des soins reçus</p>" : '';
  $e_effets .= ($deffets['e_asoinsrp'] > 0) ? "<p class=\"nbrpg_hp_high gras\">+".$deffets['e_asoinsrp']."% à l'efficacité des soins reçus</p>" : '';

  // Effets négatifs
  $e_effets .= ($deffets['e_nppt']) ? "<p class=\"nbrpg_hp_low gras\">Empêche toute action</p>" : '';
  $e_effets .= ($deffets['e_dmg'] > 0) ? "<p class=\"nbrpg_hp_low gras\">-".$deffets['e_dmg']." HP par tour</p>" : '';
  $e_effets .= ($deffets['e_precision'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_precision']."% à la précision des attaques</p>" : '';
  $e_effets .= ($deffets['e_degats'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_degats']." à la puissance d'attaque</p>" : '';
  $e_effets .= ($deffets['e_degatsp'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_degatsp']."% à la puissance d'attaque</p>" : '';
  $e_effets .= ($deffets['e_asoins'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_asoins']." à l'efficacité des soins</p>" : '';
  $e_effets .= ($deffets['e_asoinsp'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_asoinsp']."% à l'efficacité des soins</p>" : '';
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
  $e_effets .= ($deffets['e_asoinsr'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_asoinsr']." à l'efficacité des soins reçus</p>" : '';
  $e_effets .= ($deffets['e_asoinsrp'] < 0) ? "<p class=\"nbrpg_hp_low gras\">".$deffets['e_asoinsrp']."% à l'efficacité des soins reçus</p>" : '';

  // Effets spéciaux
  $e_effets .= ($deffets['e_nppt']) ? "<p class=\"gras\">Ne peut pas tuer la cible</p>" : '';
  $e_effets .= ($deffets['e_npped']) ? "<p class=\"gras\">Impossible de retirer cet effet</p>" : '';
  if($duree)
  {
    $e_effets .= ($deffets['e_reduc'] > 0) ? "<p class=\"gras\">L'effet baisse de ".$deffets['e_reduc']." chaque tour</p>" : '';
    $e_effets .= ($deffets['e_reduc'] < 0) ? "<p class=\"gras\">L'effet augmente de ".abs($deffets['e_reduc'])." chaque tour</p>" : '';
    $e_effets .= ($deffets['e_reducp'] > 0) ? "<p class=\"gras\">L'effet baisse de ".$deffets['e_reducp']."% chaque tour</p>" : '';
    $e_effets .= ($deffets['e_reducp'] < 0) ? "<p class=\"gras\">L'effet augmente de ".abs($deffets['e_reducp'])."% chaque tour</p>" : '';
  }

  // Fin de préparation des infos
  $e_effets = ($e_effets) ? "<hr class=\"points\">".$e_effets : '';
  $e_flavor = ($deffets['e_flavor']) ? "<hr class=\"points\"><p class=\"italique\">".$deffets['e_flavor']."</p>": '';

  // Et on renvoie une version formattée de l'effet
  return "<span class=\"pointeur tooltip-container\">
            <img src=\"./../../img/nbrpg/$e_icone\" alt=\"X\" style=\"border:1px solid #000000;border-radius:4px\">
            <div class=\"tooltip\">
              <p class=\"indiv align_center gras majuscules\">$e_nom</p>
              $e_duree
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
// $type est le type de dégâts, si rien n'est rentré il va prendre des dégâts physiques par défaut
// Utilisation : nbrpg_edithp(2,-4);

function nbrpg_edithp($cible,$valeur,$type=NULL)
{
  // On commence par récupérer les infos nécessaires sur la cible
  $qedithp = query("  SELECT    nbrpg_session.FKnbrpg_persos        AS 'c_perso'      ,
                                nbrpg_persos.nom                    AS 'p_nom'        ,
                                nbrpg_monstres.nom                  AS 'm_nom'        ,
                                nbrpg_session.vie                   AS 'c_hp'         ,
                                nbrpg_persos.max_vie                AS 'p_hpmax'      ,
                                nbrpg_monstres.max_vie              AS 'm_hpmax'      ,
                                arme.buff_hpmax                     AS 'p_bhpmax'     ,
                                arme.buff_hpmax_pourcent            AS 'p_bhpmax_p'   ,
                                costume.buff_hpmax                  AS 'p_bhpmax2'    ,
                                costume.buff_hpmax_pourcent         AS 'p_bhpmax_p2'  ,
                                nbrpg_monstres.resistance_physique  AS 'm_res_p'      ,
                                nbrpg_monstres.resistance_magique   AS 'm_res_m'      ,
                                arme.reduction_degats               AS 'p_res'        ,
                                arme.reduction_degats_pourcent      AS 'p_res_p'      ,
                                costume.reduction_degats            AS 'p_res2'       ,
                                costume.reduction_degats_pourcent   AS 'p_res_p2'
                      FROM      nbrpg_session
                      LEFT JOIN nbrpg_persos              ON nbrpg_session.FKnbrpg_persos         = nbrpg_persos.id
                      LEFT JOIN nbrpg_objets  AS arme     ON nbrpg_persos.FKnbrpg_objets_arme     = arme.id
                      LEFT JOIN nbrpg_objets  AS costume  ON nbrpg_persos.FKnbrpg_objets_costume  = costume.id
                      LEFT JOIN nbrpg_monstres            ON nbrpg_session.FKnbrpg_monstres       = nbrpg_monstres.id
                      WHERE     nbrpg_session.id = '$cible' ");

  // On prépare ces données avant de passer à la suite
  $dedithp                = mysqli_fetch_array($qedithp);
  $vie                    = $dedithp['c_hp'];
  $monstre                = ($dedithp['c_perso']) ? 0 : 1;
  $nom                    = ($monstre) ? $dedithp['m_nom'] : $dedithp['p_nom'];
  $hpmax                  = ($monstre) ? $dedithp['m_hpmax'] : $dedithp['p_hpmax'];
  $bonus_hpmax            = $dedithp['p_bhpmax']+$dedithp['p_bhpmax2'];
  $bonus_hpmax_p          = $dedithp['p_bhpmax_p']+$dedithp['p_bhpmax_p2'];
  $augmentation_soins     = 0;
  $augmentation_soins_p   = 0;
  $reduction_degats       = $dedithp['p_res']+$dedithp['p_res2'];
  if($monstre)
  {
    if(isset($type) && $type == 'magique')
      $reduction_degats_p = $dedithp['m_res_m'];
    else
      $reduction_degats_p = $dedithp['m_res_p'];
  }
  else
    $reduction_degats_p   = $dedithp['p_res_p']+$dedithp['p_res_p2'];

  // On va ensuite chercher les effets qui affectent la réduction des dégâts ou l'amplification des soins
  $qeffetshp = query("  SELECT    nbrpg_session_effets.duree_restante             AS 'e_duree'        ,
                                  nbrpg_effets.duree                              AS 'e_dureemax'     ,
                                  nbrpg_effets.reduction_effet_par_tour           AS 'e_reduction'    ,
                                  nbrpg_effets.reduction_effet_par_tour_pourcent  AS 'e_reduction_p'  ,
                                  nbrpg_effets.buff_hpmax                         AS 'e_hpmax'        ,
                                  nbrpg_effets.buff_hpmax_pourcent                AS 'e_hpmax_p'      ,
                                  nbrpg_effets.reduction_degats                   AS 'e_resistance'   ,
                                  nbrpg_effets.reduction_degats_pourcent          AS 'e_resistance_p' ,
                                  nbrpg_effets.amplification_soins_recus          AS 'e_extrasoins'   ,
                                  nbrpg_effets.amplification_soins_recus_pourcent AS 'e_extrasoins_p'
                        FROM      nbrpg_session_effets
                        LEFT JOIN nbrpg_effets ON nbrpg_session_effets.FKnbrpg_effets = nbrpg_effets.id
                        WHERE     nbrpg_session_effets.FKnbrpg_session = '$cible' ");

  // Et on fait des calculs sur ces effets
  while($deffetshp = mysqli_fetch_array($qeffetshp))
  {
    $duree_max                  = $deffetshp['e_dureemax'];
    $duree                      = $deffetshp['e_duree'];
    $reduction                  = $deffetshp['e_reduction'];
    $reduction_p                = $deffetshp['e_reduction_p'];
    $bonus_hpmax                += nbrpg_reduction_effet($duree_max,$duree,$deffetshp['e_hpmax'],$reduction,$reduction_p);
    $bonus_hpmax_p              += nbrpg_reduction_effet($duree_max,$duree,$deffetshp['e_hpmax_p'],$reduction,$reduction_p);
    $reduction_degats           += nbrpg_reduction_effet($duree_max,$duree,$deffetshp['e_resistance'],$reduction,$reduction_p);
    $reduction_degats_p         += nbrpg_reduction_effet($duree_max,$duree,$deffetshp['e_resistance_p'],$reduction,$reduction_p);
    $augmentation_soins         += nbrpg_reduction_effet($duree_max,$duree,$deffetshp['e_extrasoins'],$reduction,$reduction_p);
    $augmentation_soins_p       += nbrpg_reduction_effet($duree_max,$duree,$deffetshp['e_extrasoins_p'],$reduction,$reduction_p);
  }

  // On applique la réduction de dégâts ou l'amplification des soins, on calcule les nouveaux HP, et on prépare le message pour le chatlog
  if($valeur < 0)
  {
    $degats     = 0 - round(($valeur - $reduction_degats) * (1 - ($reduction_degats_p / 100)),0);
    $degats     = ($degats < 0) ? 0 : $degats;
    $vie        = $vie - $degats;
    $pluriel_hp = ($degats <= 1) ? 'point de vie' : 'points de vie';
    if($reduction_degats || $reduction_degats_p)
    {
      $valeur_n = 0 - $valeur;
      $details  = "($valeur_n";
      $details .= ($reduction_degats) ? ($reduction_degats > 0) ? " -$reduction_degats_p" : " +".(0-$reduction_degats) : '';
      $details .= ($reduction_degats_p) ? ($reduction_degats_p > 0) ? " -$reduction_degats_p%" : " +".(0-$reduction_degats_p)."%" : '';
      $details .= ")";
    }
    else
      $details  = '';
    $message    = postdata("$nom perd $degats $pluriel_hp $details");
  }
  else
  {
    $degats     = ($valeur + $augmentation_soins);
    $degats     = ($degats <= 0) ? 0 : round($degats * (1 + ($augmentation_soins_p / 100)),0);
    $vie        = $vie + $degats;
    $pluriel_hp = ($degats <= 1) ? 'point de vie' : 'points de vie';
    if($augmentation_soins || $augmentation_soins_p)
    {
      $details  = "($valeur";
      $details .= ($augmentation_soins) ? ($augmentation_soins < 0) ? " $augmentation_soins" : " +$augmentation_soins" : '';
      $details .= ($augmentation_soins_p) ? ($augmentation_soins_p < 0) ? " $augmentation_soins_p%" : " +$augmentation_soins_p%" : '';
      $details .= ")";
    }
    else
      $details  = '';
    $message    = postdata("$nom récupère $degats $pluriel_hp $details");
  }

  // On vérifie qu'on ait pas dépassé les HP max de la cible
  $hpmax_calc = nbrpg_application_effet($hpmax,$bonus_hpmax,$bonus_hpmax_p);
  $vie        = ($vie > $hpmax_calc) ? $hpmax_calc : $vie;

  // Puis on met à jour les points de vie restants à la cible
  query(" UPDATE nbrpg_session SET vie = '$vie' WHERE id = '$cible' ");

  // On envoie un message système dans le chatlog RP
  $timestamp = time();
  query(" INSERT INTO nbrpg_chatlog SET timestamp = '$timestamp' , FKmembres = 0 , type_chat = 'RP' , message = '$message'");

  // En cas de mort, on retire la cible de la session
  if($vie <= 0)
  {
    $message = ($monstre) ? postdata("$nom agonise et finit par périr de ses blessures ! RIP") : postdata("$nom est en train de décéder et quitte la session du jour pour aller se soigner :(");
    query(" INSERT INTO nbrpg_chatlog SET timestamp = '$timestamp' , FKmembres = 0 , type_chat = 'RP' , message = '$message'");
    query(" DELETE FROM nbrpg_session WHERE id = '$cible' ");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie le nom de la classe du personnage
//
// $combat, $magie, $tank, $soins, $generique sont les niveaux du personnage
// $non_assignes est un paramètre optionnel qui renvoie des infos détaillées sur la classe du perso s'il est rempli
// Utilisation : nbrpg_classe(2,0,5,0,1,0)

function nbrpg_classe($combat,$magie,$tank,$soins,$generique,$non_assignes=NULL)
{
  // Par défaut, le personnage est un aventurier
  $classe = 'Aventurier';

  // On va avoir besoin de la somme des niveaux, et du niveau le plus haut du personnage
  $niveau_total = $combat + $magie + $tank + $soins + $generique;
  $niveau_max   = max($combat,$magie,$tank,$soins,$generique);

  // On assigne les classes dans un ordre spécifique
  if($combat == $magie && $combat == $tank && $combat == $soins && $combat == $generique)
    $classe = 'Aventurier';
  else if($combat >= 3 && $combat == $niveau_max)
  {
    $classe = ($combat > 6) ? 'Guerrier' : 'Combattant';
    if($tank >= ($combat/2))
      $classe = 'Gladiateur';
    else if($generique >= ($combat/2))
      $classe = 'Trappeur';
    else if($soins >= ($combat/2))
      $classe = 'Moine combattant';
    else if($magie >= ($combat/2))
      $classe = 'Mage de guerre';
  }
  else if($magie >= 3 && $magie == $niveau_max)
  {
    $classe = ($magie > 6) ? 'Mage' : 'Magicien';
    if($soins >= ($magie/2))
      $classe = 'Mage blanc';
    else if($generique >= ($magie/2))
      $classe = 'Prestidigitateur';
    else if($combat >= ($magie/2))
      $classe = 'Mage de guerre';
    else if($tank >= ($magie/2))
      $classe = 'Érudit';
  }
  else if($tank >= 3 && $tank == $niveau_max)
  {
    $classe = ($tank > 6) ? 'Chevalier' : 'Stratège';
    if($combat >= ($tank/2))
      $classe = 'Gladiateur';
    else if($generique >= ($tank/2))
      $classe = 'Survivaliste';
    else if($soins >= ($tank/2))
      $classe = 'Protecteur';
    else if($magie >= ($tank/2))
      $classe = 'Érudit';
  }
  else if($soins >= 3 && $soins == $niveau_max)
  {
    $classe = ($soins > 6) ? 'Soigneur' : 'Guérisseur';
    if($magie >= ($soins/2))
      $classe = 'Mage blanc';
    else if($combat >= ($soins/2))
      $classe = 'Moine combattant';
    else if($tank >= ($soins/2))
      $classe = 'Protecteur';
    else if($generique >= ($soins/2))
      $classe = 'Druide';
  }
  else if($generique >= 3 && $generique == $niveau_max)
  {
    $classe = ($generique > 6) ? 'Vagabond' : 'Baroudeur';
    if($combat >= ($generique/2))
      $classe = 'Raclure';
    else if($tank >= ($generique/2))
      $classe = 'Mercenaire';
    else if($magie >= ($generique/2))
      $classe = 'Prestidigitateur';
    else if($soins >= ($generique/2))
      $classe = 'Druide';
  }

  // On renvoie le nom de la classe si on ne demande pas de détails
  if(!isset($non_assignes))
    return $classe;
  else
  {
    // Si on veut les détails, on commence par préparer les textes
    $details_classe     = '<p class="gras">'.$classe.'</p>';
    $niveaux            = ($combat > 1) ? ' niveaux' : ' niveau';
    $details_combat     = ($combat) ? '<p>'.$combat.$niveaux.' de combat</p>' : '';
    $niveaux            = ($magie > 1) ? ' niveaux' : ' niveau';
    $details_magie      = ($magie) ? '<p>'.$magie.$niveaux.' de magie</p>' : '';
    $niveaux            = ($tank > 1) ? ' niveaux' : ' niveau';
    $details_tank       = ($tank) ? '<p>'.$tank.$niveaux.' de stratégie</p>' : '';
    $niveaux            = ($soins > 1) ? ' niveaux' : ' niveau';
    $details_soins      = ($soins) ? '<p>'.$soins.$niveaux.' de médecine</p>' : '';
    $niveaux            = ($generique > 1) ? ' niveaux' : ' niveau';
    $details_generique  = ($generique) ? '<p>'.$generique.$niveaux.' d\'aventure</p>' : '';
    $niveaux            = ($non_assignes > 1) ? ' niveaux non assignés' : ' niveau non assigné';
    $details_manquants  = ($non_assignes) ? '<p>'.$non_assignes.$niveaux.'</p>' : '';

    // Puis on trie les niveaux dans l'ordre décroissant
    $details_liste = array($details_combat => $combat, $details_magie => $magie, $details_tank => $tank, $details_soins => $soins, $details_generique => $generique, $details_manquants => $non_assignes);
    arsort($details_liste);
    $details_tries = '';
    foreach ($details_liste as $resultat => $niveau)
      $details_tries .= $resultat;

    // Et on renvoie les infos complètes sur la classe du perso
    return $details_classe.$details_tries;
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie des informations sur un ennemi
//
// $nom est le nom du monstre
// $type est le type de monstre
// Utilisation : nbrpg_monstre('Schnafon','Boss');

function nbrpg_monstre($nom,$type)
{
  // On formatte la description
  $description = '<p class="gras">'.$nom.'</p>';
  $description .= '<p>'.$type.'</p>';

  // Et on envoie tout ça
  return $description;
}