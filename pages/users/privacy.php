<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly($lang);

// Menus du header
$header_menu      = 'Compte';
$header_sidemenu  = 'ReglagesViePrivee';

// Identification
$page_nom = "En a marre des GAFAM";
$page_url = "pages/users/privacy";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Options de vie privée" : "Privacy options";
$page_desc  = "Réglage des permissions liées à la protection de la vie privée";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mise à jour du niveau de vie privée

if(isset($_POST['profil_prive_go']))
{
  // Assainissement du postdata
  $membre_twitter = postdata_vide('profil_twitter', 'int', 0);
  $membre_youtube = postdata_vide('profil_youtube', 'int', 0);
  $membre_trends  = postdata_vide('profil_trends', 'int', 0);

  // Mise à jour de la valeur
  $membre_id = postdata($_SESSION['user'], 'int', 0);
  query(" UPDATE  membres
          SET     membres.voir_tweets         = '$membre_twitter' ,
                  membres.voir_youtube        = '$membre_youtube' ,
                  membres.voir_google_trends  = '$membre_trends'
          WHERE   membres.id                  = '$membre_id' ");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Niveau de vie privée actuel du membre

// On récupère l'ID du membre
$membre_id = postdata($_SESSION['user'], 'int', 0);

// On va récupérer le niveau actuel du membre
$dprive = mysqli_fetch_array(query("  SELECT  membres.voir_tweets         AS 'm_twitter'  ,
                                              membres.voir_youtube        AS 'm_youtube'  ,
                                              membres.voir_google_trends  AS 'm_trends'
                                      FROM    membres
                                      WHERE   membres.id = '$membre_id' "));

// On prépare les menus déroulants pour l'affichage
$select_twitter_0 = (!$dprive['m_twitter'])     ? ' selected' : '';
$select_twitter_1 = ($dprive['m_twitter'] == 1) ? ' selected' : '';
$select_youtube_0 = (!$dprive['m_youtube'])     ? ' selected' : '';
$select_youtube_1 = ($dprive['m_youtube'] == 1) ? ' selected' : '';
$select_trends_0  = (!$dprive['m_trends'])      ? ' selected' : '';
$select_trends_1  = ($dprive['m_trends'] == 1)  ? ' selected' : '';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']          = "Options de vie privée";
  $trad['soustitre']      = "Parce que vous avez le droit de vouloir l'anonymité totale";
  $trad['desc']           = <<<EOD
<p>
  Certaines pages du site incluent des éléments extérieurs, dont certains viennent potentiellement avec leur lot de scripts faits pour traquer vos actions sur Internet et ainsi accumuler des informations soi-disant « anonymisées » sur votre vie privée. Par exemple, les utilisateurs ont la possibilité d'inclure des vidéos <a class="gras" href="https://www.youtube.com/">YouTube</a> en utilisant un <a class="gras" href="{$chemin}pages/doc/bbcodes">BBCode</a>, et certaines pages de <a class="gras" href="{$chemin}pages/nbdb/web">l'encyclopédie de la culture web</a> utilisent des graphes <a class="gras" href="https://trends.google.fr/trends/">Google trends</a> afin de montrer l'évolution de la popularité de certains termes à travers les années.
</p>
<p>
  Pour des utilisateurs du site, il peut être préférable de ne pas profiter de ces contenus, afin de protéger au maximum leur vie privée. C'est pourquoi les options ci-dessous vous permettent, si vous le désirez, de désactiver de façon permanente les contenus en question au cas par cas.
</p>
EOD;

  // Formulaire
  $trad['twitter_niveau'] = <<<EOD
Inclusion de tweets <a href="https://www.twitter.com/">(Twitter)</a> sur le site
EOD;
  $trad['twitter_niv0']   = "Afficher les tweets";
  $trad['twitter_niv1']   = "Masquer les tweets";
  $trad['youtube_niveau'] = <<<EOD
Inclusion de vidéos <a href="https://www.youtube.com/">YouTube</a> sur le site
EOD;
  $trad['youtube_niv0']   = "Afficher les vidéos youtube";
  $trad['youtube_niv1']   = "Masquer les vidéos youtube";
  $trad['trends_niveau']  = <<<EOD
Inclusion de graphes <a class="gras" href="https://trends.google.fr/trends/">Google trends</a> dans <a href="{$chemin}pages/nbdb/web">l'encyclopédie de la culture web</a>
EOD;
  $trad['trends_niv0']    = "Afficher les graphes google trends";
  $trad['trends_niv1']    = "Masquer les graphes google trends";
  $trad['prive_go']       = "CHANGER MES OPTIONS DE VIE PRIVÉE";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']          = "Privacy options";
  $trad['soustitre']      = "Because we believe in online anonymity";
  $trad['desc']           = <<<EOD
<p>
  Certains pages of NoBleme include foreign contents, some of which might be bundled with third party tracking scripts which harvest so called "anonymous" metadata about your private life. For example, users can include <a class="gras" href="https://www.youtube.com/">YouTube</a> videos by using a <a class="gras" href="{$chemin}pages/doc/bbcodes">BBCode</a>, and some pages of the <a class="gras" href="{$chemin}pages/nbdb/web">encyclopedia of internet culture</a> use <a class="gras" href="https://trends.google.fr/trends/">Google trends</a> graphs to showcase the evolution in popularity of some of the topics it documents.
</p>
<p>
  Some users might want to hide those contents in order to maximize the protection of their privacy. If you so desire, the options below allow you to permanently deactivate some or all of those contents on NoBleme.
</p>
EOD;

  // Formulaire
  $trad['twitter_niveau'] = <<<EOD
Inclusion of tweets <a href="https://www.twitter.com/">(Twitter)</a> on the website
EOD;
  $trad['twitter_niv0']   = "Show tweets";
  $trad['twitter_niv1']   = "Hide tweets";
  $trad['youtube_niveau'] = <<<EOD
Inclusion of <a href="https://www.youtube.com/">YouTube</a> videos on the website
EOD;
  $trad['youtube_niv0']   = "Show YouTube videos";
  $trad['youtube_niv1']   = "Hide YouTube videos";
  $trad['trends_niveau']  = <<<EOD
Inclusion of <a class="gras" href="https://trends.google.fr/trends/">Google trends</a> graphs in the <a href="{$chemin}pages/nbdb/web">encyclopedia of internet culture</a>
EOD;
  $trad['trends_niv0']    = "Show Google trends graphs";
  $trad['trends_niv1']    = "Hide Google trends graphs";
  $trad['prive_go']       = "CHANGE MY PRIVACY OPTIONS";
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

        <form method="POST">
          <fieldset>

            <label for="profil_twitter"><?=$trad['twitter_niveau']?></label>
            <select id="profil_twitter" name="profil_twitter" class="indiv">
              <option value="0"<?=$select_twitter_0?>><?=$trad['twitter_niv0']?></option>
              <option value="1"<?=$select_twitter_1?>><?=$trad['twitter_niv1']?></option>
            </select><br>
            <br>

            <label for="profil_youtube"><?=$trad['youtube_niveau']?></label>
            <select id="profil_youtube" name="profil_youtube" class="indiv">
              <option value="0"<?=$select_youtube_0?>><?=$trad['youtube_niv0']?></option>
              <option value="1"<?=$select_youtube_1?>><?=$trad['youtube_niv1']?></option>
            </select><br>
            <br>

            <label for="profil_trends"><?=$trad['trends_niveau']?></label>
            <select id="profil_trends" name="profil_trends" class="indiv">
              <option value="0"<?=$select_trends_0?>><?=$trad['trends_niv0']?></option>
              <option value="1"<?=$select_trends_1?>><?=$trad['trends_niv1']?></option>
            </select><br>
            <br>

            <br>
            <input value="<?=$trad['prive_go']?>" type="submit" name="profil_prive_go">

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';