<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Play';
$header_sidemenu  = 'NBRPGWhat';

// Identification
$page_nom = "Attend sagement le retour du NBRPG";
$page_url = "pages/nbrpg/index";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = "NoBlemeRPG";
$page_desc  = "Un défunt jeu de rôle multijoueur par internet assez spécial.";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "NoBlemeRPG";
  $trad['soustitre']  = "Un défunt jeu qui reviendra Bientôt™";
  $trad['desc']       = <<<EOD
<p>
  Pendant une décennie entière, les NoBlemeux ont pu jouer sur <a class="gras" href="{$path}pages/irc/index">le serveur IRC NoBleme</a> à un jeu de rôle assez spécial qui s'appelait le NoBlemeRPG. Dans ce jeu non linéaire, un groupe de joueurs dont la composition variait d'une session à l'autre devait accomplir des missions pour une entité mystérieuse nommée l'Oracle, évoluant au sein d'un univers de jeu où absolument tout ce qui était imaginable était possible.
</p>
<p>
  Après un dernier arc en 2015 pour conclure les dix ans d'histoire du jeu, la version classique du NoBlemeRPG a atteint la fin de sa vie. Un nouveau NoBlemeRPG plus moderne, joué directement dans le navigateur, avait été assemblé en 2016. Malheureusement, cet idiot de <a class="gras" href="{$path}pages/users/user?id=1">Bad</a> est un perfectionniste et n'accepte pas de publier un jeu qui n'est pas 100% fun. Le remake du NBRPG était aux alentours de 90% fun, ce qui ne suffisait pas. Quand Bad aura trouvé les 10% manquants, le jeu reviendra. Un de ces jours...
</p>
<p>
  En attendant le retour inévitable du NoBlemeRPG dans un corps tout neuf (Bientôt™), je vous laisse avec quelques <a class="gras" href="{$path}pages/nbrpg/archives">sessions de jeu archivées</a> pour assouvir votre curiosité.
</p>
EOD;
  $trad['pins']       = "Illustration grâcieusement offerte par ce bon vieux";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "NoBlemeRPG";
  $trad['soustitre']  = "A dead game that might come back Soon™";
  $trad['desc']       = <<<EOD
<p>
  For a whole decade, NoBleme users got on <a class="gras" href="{$path}pages/irc/index">our IRC server</a> to play a rather special role playing game called the NoBlemeRPG. In this non linear game, a group of players which changed every session had to accomplish errands for a mysterious entity called the Oracle, evolving through a game universe in which literally every action imaginable was possible to attempt.
</p>
<p>
  After a final story arc in 2015 which concluded ten years of storylines, the classic version of the NoBlemeRPG reached the end of its life cycle. A modernized version of the NBRPG, playable through the browser, had been assembled in 2016. Sadly, <a class="gras" href="{$path}pages/users/user?id=1">Bad</a> being a perfectionist, he did not want to release a game that wasn't 100% fun. As the remake is only about 90% fun, it will be back once Bad finds the missing 10%. One of those days...
</p>
EOD;
  $trad['pins']       = "Image drawn by good old";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <?=$trad['desc']?>

        <br>
        <br>
        <br>

        <div class="align_center">
          <img src="<?=$path?>img/divers/nbrpg.png" alt="NoBlemeRPG"><br>
          <span class="italique"><?=$trad['pins']?> <a class="gras" href="https://twitter.com/chance_meeting?lang=fr">pins</a></span>
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';