<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'MiscIndex';

// Identification
$page_nom = "Se marre devant les miscellanées";
$page_url = "pages/quotes/index";

// Langues disponibles
$langue_page = array('FR', 'EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Miscellanées" : "Miscellanea";
$page_desc  = "Intéractions entre NoBlemeux qui ont été conservées pour la postérité";

// JS
$js = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les citations
$qmisc = "    SELECT    quotes.id           AS 'q_id'       ,
                        quotes.timestamp    AS 'q_time'     ,
                        quotes.contenu      AS 'q_contenu'  ,
                        quotes.nsfw         AS 'q_nsfw'     ,
                        quotes.valide_admin AS 'q_valide'
              FROM      quotes
              WHERE     1 = 1 ";

// Version admin ou non
if(!$est_admin)
  $qmisc .= " AND       quotes.valide_admin = 1 ";

// Recherche
if(isset($_POST['misc_recherche']))
{
  $misc_recherche = postdata_vide('misc_recherche', 'string', '');
  $misc_langue    = postdata_vide('misc_langue', 'string', 'FR');
  $qmisc .= " AND       quotes.contenu LIKE '%$misc_recherche%' collate utf8mb4_general_ci ";
  if($misc_langue != 'All')
    $qmisc .= " AND     quotes.langue LIKE '$misc_langue' ";
}
else
{
  $misc_langue = postdata($lang, 'string', 'FR');
  $qmisc .= " AND       quotes.langue LIKE '$misc_langue' ";
}

// Tri
$qmisc .= "   ORDER BY  quotes.valide_admin ASC   ,
                        quotes.timestamp    DESC  ,
                        quotes.id           DESC  ";

// On envoie la requête
$qmisc = query($qmisc);

// Préparation des données pour l'affichage
$misc_admin = getadmin();
for($nmisc = 0; $dmisc = mysqli_fetch_array($qmisc); $nmisc++)
{
  $misc_id[$nmisc]      = $dmisc['q_id'];
  $temp_date_fr         = ($dmisc['q_time']) ? '<span class="gras">du '.predata(jourfr(date('Y-m-d', $dmisc['q_time']), 'FR')).'</span>' : '';
  $temp_date_en         = ($dmisc['q_time']) ? '<span class="gras">'.predata(jourfr(date('Y-m-d', $dmisc['q_time']), 'EN')).'</span>' : '';
  $misc_date[$nmisc]    = ($lang == 'FR') ? $temp_date_fr : $temp_date_en;
  $misc_contenu[$nmisc] = ($dmisc['q_valide']) ? '' : '<span class="texte_negatif">---- MISCELLANÉE NON VALIDÉE ! ----<br>';
  $misc_contenu[$nmisc] .= predata($dmisc['q_contenu'], 1, 1);
  $misc_contenu[$nmisc] .= ($dmisc['q_valide']) ? '' : '<br>---- MISCELLANÉE NON VALIDÉE ! ----</span>';
  $niveau_nsfw          = niveau_nsfw();
  $misc_nsfw[$nmisc]    = ($niveau_nsfw) ? 0 : $dmisc['q_nsfw'];

  // On a aussi besoin des membres liés à la miscellanée
  $tempid               = $dmisc['q_id'];
  $qmiscpseudos         = query(" SELECT      quotes_membres.FKmembres  AS 'qm_id' ,
                                              membres.pseudonyme        AS 'qm_pseudo'
                                  FROM        quotes_membres
                                  LEFT JOIN   membres ON quotes_membres.FKmembres = membres.id
                                  WHERE       quotes_membres.FKquotes = '$tempid'
                                  ORDER BY    membres.pseudonyme ASC ");
  $temp_pseudos         = '';
  for($nmiscpseudos = 0; $dmiscpseudos = mysqli_fetch_array($qmiscpseudos); $nmiscpseudos++)
  {
    $temp_pseudos      .= ($nmiscpseudos) ? ', ' : '';
    $temp_pseudos      .= '<a href="'.$chemin.'pages/user/user?id='.$dmiscpseudos['qm_id'].'">'.predata($dmiscpseudos['qm_pseudo']).'</a>';
  }
  $misc_pseudos[$nmisc] = ($temp_pseudos) ? '<span class="gras">(</span>'.$temp_pseudos.'<span class="gras">)</span>' : '';
}

// Langues pour le menu déroulant
$select_lang_fr = ($lang == 'FR') ? ' selected' : '';
$select_lang_en = ($lang == 'EN') ? ' selected' : '';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']                = "Miscellanées";
  $trad['soustitre']            = "Petites citations amusantes";
  $trad['desc1']                = <<<EOD
Miscellanée : nom féminin, ordinairement au pluriel.<br>
Bibliothèque hétéroclite, recueil de différents ouvrages qui n'ont quelquefois aucun rapport entre eux.
EOD;
  $trad['desc2']                = <<<EOD
Les miscellanées sont des phrases, des monologues, des conversations entre les NoBlemeux qui sont été conservés pour la posterité. Elles vous sont présentées sur cette page par ordre antéchronologique. Si vous assistez à une conversation sur NoBleme et pensez qu'elle mérite de figurer dans les miscellanées, vous pouvez <a class="gras" href="{$chemin}pages/quotes/add">proposer une miscellanée</a>.
EOD;
  $trad['desc3']                = <<<EOD
Certaines miscellanées sont floutées car elles contiennent du contenu vulgaire ou sensible, et requièrent que vous passiez votre curseur dessus afin de les réveler. Si le floutage vous ennuie, vous pouvez le désactiver de façon permanente via les <a class="gras" href="{$chemin}pages/user/nsfw">options de vulgarité</a> de votre compte.
EOD;

  // Formulaire de recherche
  $trad['misc_search_lang']     = "Langues des miscellanées à afficher :";
  $trad['misc_search_langfr']   = "Citations en français uniquement";
  $trad['misc_search_langen']   = "Citations en anglais uniquement";
  $trad['misc_search_langall']  = "Toutes les citations (français + anglais)";
  $trad['misc_search_text']     = "Rechercher dans les miscellanées :";
  $trad['misc_search_default']  = "Écrivez du texte ici si vous souhaitez faire une recherche";

  // Liste des miscellanées
  $trad['misc_liste_titre']     = "Liste des $nmisc miscellanées :";
  $trad['misc_liste_titre2']    = "$nmisc miscellanées trouvées :";
  $trad['misc_liste_zero']      = "Aucun résultat pour la recherche";
  $trad['misc_liste_misc']      = "Miscellanée";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']                = "Miscellanea";
  $trad['soustitre']            = "Repository of funny-ish quotes";
  $trad['desc1']                = <<<EOD
Miscellanea: a collection of miscellaneous items, esp literary works.
EOD;
  $trad['desc2']                = <<<EOD
Miscellanea are phrases, monologues, or conversations between NoBleme users which are being kept here for posterity. They are presented to you on this page in reverse chronological order. If you witness a conversation on NoBleme and feel that it is worthy of being preserved here, you can <a class="gras" href="{$chemin}pages/quotes/add">submit a quote proposal</a>.
EOD;
  $trad['desc3']                = <<<EOD
Some miscellanea are blurred due to the crude or sensitive content they contain, and require you to hover your mouse cursor over them in order to reveal their contents. If you are bothered by the blurring or have no need for it, you can permanently disable it in the <a class="gras" href="{$chemin}pages/user/nsfw">adult content options</a> of your account.
EOD;

  // Formulaire de recherche
  $trad['misc_search_lang']     = "Display quotes in the following languages:";
  $trad['misc_search_langfr']   = "Quotes in french only";
  $trad['misc_search_langen']   = "Quotes in english only";
  $trad['misc_search_langall']  = "All the quotes (english + french)";
  $trad['misc_search_text']     = "Search in the miscellanea:";
  $trad['misc_search_default']  = "Write text here if you want to perform a search";

  // Liste des miscellanées
  $trad['misc_liste_titre']     = "List of $nmisc miscellanea:";
  $trad['misc_liste_titre2']    = "$nmisc miscellanea found:";
  $trad['misc_liste_zero']      = "Your search yielded no results";
  $trad['misc_liste_misc']      = "Quote";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte2">

        <h1>
          <?=$trad['titre']?>
          <a href="<?=$chemin?>pages/quotes/add">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" height="30">
          </a>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="RSS" height="30">
          </a>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
        </h5>

        <p class="italique">
          <?=$trad['desc1']?>
        </p>

        <p>
          <?=$trad['desc2']?>
        </p>

        <?php if(!$niveau_nsfw) { ?>
        <p>
          <?=$trad['desc3']?>
        </p>
        <?php } ?>

        <br>
        <br>

        <fieldset>

          <label for="miscLang"><?=$trad['misc_search_lang']?></label>
          <select class="indiv" id="miscLang" name="miscLang" onchange="dynamique('<?=$chemin?>', 'index.php', 'misc_quotes', 'misc_recherche='+dynamique_prepare('miscRecherche')+'&misc_langue='+dynamique_prepare('miscLang'), 1);">
          <option value="FR"<?=$select_lang_fr?>><?=$trad['misc_search_langfr']?></option>
          <option value="EN"<?=$select_lang_en?>><?=$trad['misc_search_langen']?></option>
          <option value="All"><?=$trad['misc_search_langall']?></option>
          </select><br>
          <br>

          <label for="miscRecherche"><?=$trad['misc_search_text']?></label>
          <input id="miscRecherche" name="miscRecherche" class="indiv" type="text" placeholder="<?=$trad['misc_search_default']?>" onkeyup="dynamique('<?=$chemin?>', 'index.php', 'misc_quotes', 'misc_recherche='+dynamique_prepare('miscRecherche')+'&misc_langue='+dynamique_prepare('miscLang'), 1);"><br>
          <br>

        </fieldset>

        <br>

        <div id="misc_quotes">

          <h5>
            <?=$trad['misc_liste_titre']?>
          </h5>

          <?php } if(getxhr() && $nmisc) { ?>

          <h5>
            <?=$trad['misc_liste_titre2']?>
          </h5>

          <?php } else if(getxhr()) { ?>

          <h5>
            <?=$trad['misc_liste_zero']?>
          </h5>

          <?php } for($i=0;$i<$nmisc;$i++) { ?>

          <p class="monospace align_left">
            <a class="gras" href="<?=$chemin?>pages/quotes/quote?id=<?=$misc_id[$i]?>"><?=$trad['misc_liste_misc']?> #<?=$misc_id[$i]?></a> <?=$misc_date[$i]?> <?=$misc_pseudos[$i]?>
            <?php if($misc_admin) { ?>
            - <a class="gras" href="<?=$chemin?>pages/quotes/edit?id=<?=$misc_id[$i]?>">Modifier</a> - <a class="gras" href="<?=$chemin?>pages/quotes/delete?id=<?=$misc_id[$i]?>">Supprimer</a>
            <?php } ?>
            <br>

            <?php if($misc_nsfw[$i]) { ?>
            <span class="flou">
              <?=$misc_contenu[$i]?>
            </span>
            <?php } else { ?>
              <?=$misc_contenu[$i]?>
            <?php } ?>
          </p>

          <?php } if(!getxhr()) { ?>

        </div>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }