<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                     DÉMARRAGE DU BOT IRC NOBLEME                                                      */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Interdiction de faire tourner le bot si on est sur localhost
if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "127.0.0.1")
  erreur('Le bot ne devrait pas tourner en localhost plz');



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Démarrage du bot

// Réglages
$fichier_bot  = $chemin."ircbot.txt";
$pseudo_bot   = "NoBleme";
$pass_bot     = $GLOBALS['bot_pass'];

// Si le fichier txt n'existe pas, c'est pas la peine le lancer le bot
if(!file_exists($fichier_bot))
  erreur('Pas de fichier');

// On ouvre le socket IRC
if(!$socket_irc = fsockopen("irc.nobleme.com", 6667))
  erreur('Connexion au serveur IRC impossible');

// On veut une time limit infinie vu que le script tourne à l'infini (en théorie)
set_time_limit(0);

// On déclare son user et on change de nick
fputs($socket_irc,"USER $pseudo_bot $pseudo_bot $pseudo_bot $pseudo_bot :$pseudo_bot\r\n");
fputs($socket_irc,"NICK $pseudo_bot\r\n");

// Ça prompte une demande de PONG, on va chercher le PING et y répondre
$fetchping = fgets($socket_irc);
$fetchping = fgets($socket_irc);
$fetchping = fgets($socket_irc);
fputs($socket_irc, str_replace('PING','PONG',$fetchping)."\r\n");

// Si le pong est accepté, on peut join les canaux
fputs($socket_irc,"JOIN #NoBleme\r\n");
fputs($socket_irc,"JOIN #dev\r\n");
fputs($socket_irc,"JOIN #english\r\n");
fputs($socket_irc,"JOIN #forum\r\n");
fputs($socket_irc,"JOIN #write\r\n");

// Et ne pas oublier de s'indentifier pour ne pas se faire troller par nickserv
fputs($socket_irc,"NickServ IDENTIFY $pseudo_bot $pass_bot\r\n");

// Joindre le canal des sysops après s'être identifié
fputs($socket_irc,"JOIN #sysop\r\n");

// On reset le dernier message avant d'entrer dans la boucle
$dernier_message = file_get_contents($fichier_bot);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Boucle infinie dans laquelle le bot fonctionne

while(1) {

  // Il faut refaire ce réglage à chaque loop sinon il peut hang, thx PHP pour les quirks à la con
  stream_set_timeout($socket_irc,1);

  // On doit check le stream IRC pour savoir s'il y un PONG à répondre
  while (($contenu_socket_irc = fgets($socket_irc, 512)) !== false) {
    flush();

    // Si c'est un PING, on PONG en retour
    $fetchping = explode(' ', $contenu_socket_irc);
    if($fetchping[0] == 'PING')
      fputs($socket_irc,"PONG ".$fetchping[1]."\r\n");
  }

  // Si le fichier .txt disparait, on tue le bot
  if(!file_exists($fichier_bot))
  {
    fputs($socket_irc,"QUIT :Le fichier n'existe plus\r\n");
    exit();
  }

  // On check si le fichier .txt contient une demande de quit manuelle
  if(substr(file_get_contents($fichier_bot),0,4) == 'quit' || substr(file_get_contents($fichier_bot),11,4) == 'quit')
  {
    fputs($socket_irc,"QUIT :Demande de quit manuelle\r\n");
    exit();
  }

  // On check s'il y a un nouveau message à poster dans le fichier .txt
  if($dernier_message != file_get_contents($fichier_bot))
  {
    // On met le contenu du fichier en mémoire
    $dernier_message = file_get_contents($fichier_bot);

    // On balance la première ligne
    $fichier_bot_contenu = fopen($fichier_bot, 'r');
    $ligne_bot = fgets($fichier_bot_contenu);
    fputs($socket_irc, substr($ligne_bot, 11).PHP_EOL);
    fclose($fichier_bot_contenu);

    // On vire la première ligne du fichier
    $contents = file($fichier_bot, FILE_IGNORE_NEW_LINES);
    $first_line = array_shift($contents);
    file_put_contents($fichier_bot, implode("\r\n", $contents));
  }

  // Et on évite le memory leak exponentiel en flushant le buffer puis collectant de force le garbage
  flush();
  gc_collect_cycles();
}