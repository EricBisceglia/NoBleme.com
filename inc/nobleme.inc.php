<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction vérifiant que le membre n'ait pas déjà fait une action récemment
//
// Utilisation: antiflood($lang);

function antiflood()
{
  // On prépare certains messages bilingues
  $lang                 = (!isset($_SESSION['lang'])) ? 'FR' : $_SESSION['lang'];
  $temp_lang_loggedout  = ($lang == 'FR') ? 'Vous devez être connecté pour effectuer cette action' : 'You can only do this action while logged into your account';
  $temp_lang_flood      = ($lang == 'FR') ? 'Vous devez attendre quelques secondes entre chaque action<br><br>Réessayez dans 10 secondes' : 'You must wait a bit between each action on the website<br><br>Try doing it again in 10 seconds';

  // Si on a affaire à un user pas connecté, on s'arrête là
  if(!loggedin())
    erreur($temp_lang_loggedout);

  // Sinon, on va chercher la dernière activité du membre
  else
  {
    // On assainit l'ID
    $membre_id = postdata($_SESSION['user'], 'int', 0);

    // On va chercher la dernière activité
    $dactivite = mysqli_fetch_array(query(" SELECT  membres.derniere_activite AS 'm_activite'
                                            FROM    membres
                                            WHERE   membres.id = '$membre_id' "));

    // Si elle n'existe pas, erreur
    if($dactivite['m_activite'] == NULL)
      erreur($temp_lang_loggedout, NULL, $lang);

    // Si la dernière activité est trop récente, erreur
    $timestamp = time();
    if(($timestamp - $dactivite['m_activite']) <= 10 )
      erreur($temp_lang_flood);

    // Si ça passe, on met à jour la date de dernière activité
    query(" UPDATE  membres
            SET     membres.derniere_activite = '$timestamp'
            WHERE   membres.id = '$membre_id' ");

    // On laisse passer l'activité
    return 1;
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction envoyant un message privé type "message système" à un utilisateur à partir de son ID
//
// Utilisation: envoyer_notif($destinataire,$titre,$contenu,$silent);
//
// Si $sender est NULL, alors le message sera un message système
// Si $silent est set, alors le message sera considéré comme déjà lu

function envoyer_notif($en_destinataire,$en_titre,$en_contenu,$sender=NULL,$silent=NULL)
{
  // Préparation des données
  $en_date    = time();
  $en_titre   = $en_titre;
  $en_contenu = $en_contenu;

  // Message système ou pm
  $en_sender = 0;
  if($sender)
    $en_sender = $sender;

  // Notification silencieuse
  $en_consult = 0;
  if($silent)
    $en_consult = time();

  // Insertion des données
  query(" INSERT INTO   notifications
          SET           notifications.FKmembres_destinataire  = '$en_destinataire'  ,
                        notifications.FKmembres_envoyeur      = '$en_sender'        ,
                        notifications.date_envoi              = '$en_date'          ,
                        notifications.date_consultation       = '$en_consult'       ,
                        notifications.titre                   = '$en_titre'         ,
                        notifications.contenu                 = '$en_contenu'       ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Insère une entrée dans la table activite, retourne l'id de l'activité qui vient d'être crée
//
// type_action                    est le le type d'action, pour son traitement dans pages/nobleme/activite
// log_moderation                 définit si c'est public (0) ou un log de modération (1)
// membre_id          (optionnel) est l'ID du membre lié à l'activité
// membre_pseudonyme  (optionnel) est le pseudonyme du membre lié à l'activité
// action_id          (optionnel) est l'id d'une table externe auquel l'action est lié
// action_titre       (optionnel) est le titre de l'action, pour son traitement dans pages/nobleme/activite
// action_parent      (optionnel) est un élément parent à l'action, pour son traitement dans pages/nobleme/activite
// justification      (optionnel) est la justification de l'action dans le log de modération
//
// Utilisation: $activite_id = activite_nouveau('truc_edit', 0, 0, 'Bad', 42, 'Le truc édité');

function activite_nouveau($type_action, $log_moderation, $membre_id=0, $membre_pseudonyme=NULL, $action_id=0, $action_titre=NULL, $action_parent=NULL, $justification=NULL)
{
  // On crée la nouvelle activité
  $timestamp = time();
  query(" INSERT INTO activite
          SET         activite.timestamp      = '$timestamp'          ,
                      activite.log_moderation = '$log_moderation'     ,
                      activite.FKmembres      = '$membre_id'          ,
                      activite.pseudonyme     = '$membre_pseudonyme'  ,
                      activite.action_type    = '$type_action'        ,
                      activite.action_id      = '$action_id'          ,
                      activite.action_titre   = '$action_titre'       ,
                      activite.parent         = '$action_parent'      ,
                      activite.justification  = '$justification'      ");

  // Puis on renvoie l'id de l'activité fraichement crée
  return(mysqli_insert_id($GLOBALS['db']));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Insère une entrée dans la table activite_diff
//
// id                     est l'id de l'activité liée au diff
// titre                  est le titre du diff
// avant                  est le contenu qui était présent avant le diff
// apres      (optionnel) est le contenu qui en remplace un autre dans le diff
// optionnel  (optionnel) spécifie que le diff ne doit être crée que si le contenu d'après est différent du contenu d'avant
//
// Utilisation: activite_diff(1, 'Valeur', 3, 5, 1);

function activite_diff($id, $titre, $avant, $apres=NULL, $optionnel=NULL)
{
  // Si le contenu est trop grand, on ne crée pas de diff
  $apres = (strlen($apres) > 10000) ? NULL : $apres;

  // On crée le diff (si nécessaire)
  if(!$optionnel || $avant != $apres)
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id'     ,
                        titre_diff  = '$titre'  ,
                        diff_avant  = '$avant'  ,
                        diff_apres  = '$apres'  ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Purge le contenu de la table activite_diff qui n'est lié à aucune entrée dans la table activite
//
// Utilisation: purger_diff_orphelins()

function purger_diff_orphelins()
{
  // On va chercher les orphelins
  $qorphelins = query(" SELECT    activite_diff.id AS 'd_id'
                        FROM      activite_diff
                        LEFT JOIN activite ON activite_diff.FKactivite = activite.id
                        WHERE     activite.id IS NULL ");

  // Et on les asphyxie discrètement
  while($dorphelins = mysqli_fetch_array($qorphelins))
  {
    $id_orphelin = $dorphelins['d_id'];
    query(" DELETE FROM activite_diff
            WHERE       activite_diff.id = '$id_orphelin' ");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Supprime une entrée dans la table activite ainsi que toutes les entrées liées dans activite_diff
//
// type_action                    est le le type d'activité à supprimer
// log_moderation     (optionnel) définit si c'est public (0) ou un log de modération (1)
// membre_id          (optionnel) est l'ID du membre lié à l'activité à supprimer
// membre_pseudonyme  (optionnel) est le pseudonyme du membre lié à l'activité à supprimer
// action_id          (optionnel) est l'id d'une table externe à laquelle l'activité est lié
// type_action_tout   (optionnel) s'il est rempli, supprime toutes les actions de ce type
//
// Utilisation: activite_supprimer('truc_edit', 42);

function activite_supprimer($type_action, $log_moderation=0, $membre_id=0, $membre_pseudonyme=NULL, $action_id=0, $type_action_tout=0)
{
  // On construit la requête selon les paramètres qui sont remplis ou non
  $activite_supprimer    = "  DELETE FROM activite ";

  // Type d'action, englobant toutes les actions du type ou non
  if(!$type_action_tout)
    $activite_supprimer .= "  WHERE       activite.action_type    LIKE  '$type_action' ";
  else
    $activite_supprimer .= "  WHERE       activite.action_type    LIKE  '$type_action%' ";

  // Activité récente ou log de modération
  $activite_supprimer .= "    AND         activite.log_moderation =     '$log_moderation' ";

  // Autres paramètres
  if($membre_id)
    $activite_supprimer .= "  AND         activite.FKmembres      =     '$membre_id' ";
  if($membre_pseudonyme)
    $activite_supprimer .= "  AND         activite.pseudonyme     LIKE  '$membre_pseudonyme' ";
  if($action_id)
    $activite_supprimer .= "  AND         activite.action_id      =     '$action_id' ";

  // On supprime l'activité
  query($activite_supprimer);

  // Et on envoie une purge des diffs potentiellement orphelins suite à la suppression
  purger_diff_orphelins();
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction vérifiant l'existence d'une entrée dans une table de la base de données
//
// $table   est le nom de la table
// $id      est l'id à chercher dans la table
//
// Utilisation: verifier_existence('membres', 1);

function verifier_existence($table, $id)
{
  // On va vérifier si le champ existe
  $qcheck = mysqli_fetch_array(query("  SELECT  ".$table.".id AS 't_id'
                                        FROM    $table
                                        WHERE   ".$table.".id = '".$id."' "));

  // Puis on revoie 1 ou 0 selon si l'id existe ou non
  $return = ($qcheck['t_id']) ? 1 : 0;
  return $return;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie une (ou aucune) propriété CSS correspondant à un menu de navigation du header, selon si l'option est sélectionnée ou non
//
// Le premier paramètre est l'option de menu actuellement sélectionnée
// Le second paramètre est l'option de menu dont on veut récupérer le CSS
// Le troisième paramètre est le type de menu (0 -> menu principal / 1 -> sous-menu / 2 -> menu latéral)
//
// Utilisation: menu_css($header_menu,'communaute',0)

function menu_css($menu_postdata, $menu_objet, $menu_type)
{
  // Si l'entrée est sélectionnée, on renvoie le CSS approprié
  if($menu_postdata == $menu_objet)
  {
    if($menu_type == 0)
      return ' menu_main_item_selected';
    else if($menu_type == 1)
      return ' menu_sub_item_selected';
    else if($menu_type == 2)
      return ' menu_side_item_selected';
  }

  // Si elle n'est pas sélectionnée, on ne renvoie rien, sauf dans le cas du menu secret
  else
  {
    if($menu_objet == 'secrets' && $menu_type == 0)
      return ' menu_main_item_secrets';
    else
      return '';
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction envoyant un message qui sera broadcasté par le bot IRC NoBleme s'il est en ligne
//
// Le premier paramètre optionnel permet de spécifier un canal sur lequel écrire le message
// Le second paramètre optionnel autorise les codes de formattage de texte
//
// Utilisation: ircbot($chemin,"PRIVMSG #NoBleme :Bonjour !");
// Utilisation: ircbot($chemin,"Bonjour !","#NoBleme");

function ircbot($chemin,$message_irc,$canal_irc=NULL,$formattage=NULL)
{
  // On assainit le message
  $message_irc = str_replace("\\n", '', $message_irc);
  $message_irc = str_replace("\\r", '', $message_irc);
  $message_irc = str_replace("\\t", '', $message_irc);

  // On formatte le message si c'est autorisé
  if($formattage)
  {
    // Substitution des bytes de formattage
    $message_irc = str_replace('%O',chr(0x0f),$message_irc);        // Remise à zéro
    $message_irc = str_replace('%B',chr(0x02),$message_irc);        // Gras
    $message_irc = str_replace('%I',chr(0x1d),$message_irc);        // Italique
    $message_irc = str_replace('%U',chr(0x1f),$message_irc);        // Souligné
    $message_irc = str_replace('%C00',chr(0x03).'00',$message_irc); // Couleur : Blanc
    $message_irc = str_replace('%C01',chr(0x03).'01',$message_irc); // Couleur : Noir
    $message_irc = str_replace('%C02',chr(0x03).'02',$message_irc); // Couleur : Bleu
    $message_irc = str_replace('%C03',chr(0x03).'03',$message_irc); // Couleur : Vert
    $message_irc = str_replace('%C04',chr(0x03).'04',$message_irc); // Couleur : Rouge
    $message_irc = str_replace('%C05',chr(0x03).'05',$message_irc); // Couleur : Marron
    $message_irc = str_replace('%C06',chr(0x03).'06',$message_irc); // Couleur : Violet
    $message_irc = str_replace('%C07',chr(0x03).'07',$message_irc); // Couleur : Orange
    $message_irc = str_replace('%C08',chr(0x03).'08',$message_irc); // Couleur : Jaune
    $message_irc = str_replace('%C09',chr(0x03).'09',$message_irc); // Couleur : Vert clair
    $message_irc = str_replace('%C10',chr(0x03).'10',$message_irc); // Couleur : Bleu vert
    $message_irc = str_replace('%C11',chr(0x03).'11',$message_irc); // Couleur : Cyan clair
    $message_irc = str_replace('%C12',chr(0x03).'12',$message_irc); // Couleur : Bleu clair
    $message_irc = str_replace('%C13',chr(0x03).'13',$message_irc); // Couleur : Rose
    $message_irc = str_replace('%C14',chr(0x03).'14',$message_irc); // Couleur : Gris

    // Bytes de formattage personnalisés / combinés
    $message_irc = str_replace('%NB',chr(0x02).chr(0x03).'00,01',$message_irc);               // Fond noir, texte blanc gras
    $message_irc = str_replace('%TROLL',chr(0x1f).chr(0x02).chr(0x03).'08,13',$message_irc);  // Fond rose, texte jaune gras, souligné
  }

  // Si on peut écrire dans le fichier, on remplace son contenu par le message
  if($fichier_ircbot = fopen($chemin.'ircbot.txt', "a"))
  {
    if(!$canal_irc)
      file_put_contents($chemin.'ircbot.txt', time()." ".substr($message_irc,0,450).PHP_EOL, FILE_APPEND);
    else
      file_put_contents($chemin.'ircbot.txt', time()." PRIVMSG ".$canal_irc." :".substr($message_irc,0,450).PHP_EOL, FILE_APPEND);
    fclose($fichier_ircbot);
    return 1;
  }
  else
    return 0;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction générant un surnom aléatoire pour un unvité
//
// Utilisation: surnom_mignon();

function surnom_mignon()
{
  // Liste de mots (les adjectif1 doivent prendre un espace s'ils ne se collent pas au nom)
  $adjectif1 = array("Petit ", "Gros ", "Sale ", "Grand ", "Bel ", "Doux ", "L'", "Un ", "Cet ", "Ce ", "Premier ", "Gentil ", "Méchant ", "Bout d'", "Le ", "Capitaine ", "Quel ", "Saint ", "Chétif ", "Président ", "Général ", "Dernier ", "L'unique ", "Ex ", "Archi ", "Méga ", "Micro ", "Fort ", "Demi ", "Cadavre de ", "Âme d'", "Fils du ", "Futur ", "Second ", "Meta-");

  $nom = array("ours", "oiseau", "chat", "chien", "canard", "pigeon", "haricot", "arbre", "rongeur", "pot de miel", "indien", "gazon", "paysan", "crouton", "mollusque", "bouc", "éléphant", "sanglier", "journal", "singe", "cœur", "félin", "", "morse", "phoque", "miquet", "kévin", "monstre", "meuble", "frelon", "robot", "slip", "cousin", "frère", "internet", "type", "copain", "raton", "mouton", "VIP");

  $âdjectif2 = array("solitaire", "mignon", "moche", "farouche", "mystérieux", "con", "lourdingue", "glandeur", "douteux", "noir", "blanc", "rose", "mauve", "chaotique", "pâle", "raciste", "rigolo", "choupinet", "borgne", "douteux", "baltique", "fatigué", "", "peureux", "millénaire", "belge", "bouseux", "crade", "des champs", "urbain", "sourd", "techno", "fatigué", "cornu", "mort", "cool", "moelleux");

  // On assemble le surnom
  $surnom = $adjectif1[rand(0,(count($adjectif1)-1))].$nom[rand(0,(count($nom)-1))]." ".$âdjectif2[rand(0,(count($âdjectif2)-1))];

  // Et on balance la sauce
  return($surnom);
}