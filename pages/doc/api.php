<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'API';

// Identification
$page_nom = "Veut connecter son app à NoBleme";
$page_url = "pages/doc/api";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "API" : "API";
$page_desc  = "Documentation de l'API publique de NoBleme.com";

// JS
$js = array('highlight');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']              = "API publique de NoBleme";
  $trad['soustitre']          = "Pour les développeurs qui veulent aller plus loin avec le site";
  $trad['desc']               = <<<EOD
NoBleme possède une <a class="gras" href="https://fr.wikipedia.org/wiki/Interface_de_programmation">API</a> publique, c'est à dire une façon d'envoyer des demandes à NoBleme.com auxquelles il répond dans un format standardisé. Cela permet à des programmes ou applications externes d'utiliser des données en provenance NoBleme sans avoir à trop se compliquer la vie. Cette page s'adresse aux développeurs qui savent ce qu'ils font : si vous ne comprenez pas ce qu'est une API, c'est que vous ne tirerez probablement rien d'utile de cette page.
EOD;
  $trad['desc2']              = <<<EOD
L'API de NoBleme est en lecture seule, c'est à dire que vous pouvez lui demander de lister des contenus qui se trouvent sur le site, mais vous ne pouvez pas lui demander de modifier ou supprimer des contenus du site. De plus, c'est une API publique, cela signifie que vous n'avez pas à vous authentifier pour demander des données à l'API, mais aussi que cette API est limitée aux données publiques - vous ne pouvez pas lui demander des données privées liées à votre compte.
EOD;
  $trad['desc3']              = <<<EOD
Ci-dessous, vous trouverez une documentation complète des sections du site auxquelles vous pouvez faire des requêtes à partir de l'API publique de NoBleme, accompagnée d'exemples. Les données renvoyées par les requêtes sont sous forme d'un <span class="gras">tableau d'objets JSON</span>. Si une requête ne renvoie aucun résultat, elle renverra une <span class="gras">erreur 404</span> au lieu de renvoyer un tableau d'objets JSON.
EOD;

  // Données communes
  $trad['api_renvoi']         = "Données renvoyées :";
  $trad['api_params']         = "Paramètres possibles :";
  $trad['api_champ']          = "CHAMP";
  $trad['api_type']           = "TYPE";
  $trad['api_contenu']        = "CONTENU";
  $trad['api_param']          = "PARAMÈTRE";
  $trad['api_importance']     = "IMPORTANCE";
  $trad['api_desc']           = "DESCRIPTION";
  $trad['api_optionnel']      = "Optionnel";
  $trad['api_exemples']       = "Exemples d'utilisation :";

  // Encyclopédie de la culture web
  $trad['apinbdb_titre']      = "Encyclopedie de la culture web";
  $trad['apinbdb_tri']        = <<<EOD
Les données sont renvoyées <span class="gras">triées par titre</span>, dans l'ordre alphabétique.
EOD;
  $trad['apinbdb_ruuid']      = "Un identifiant unique, sans rapport avec la page";
  $trad['apinbdb_rtype']      = "Type de page ('encyclopedia' ou 'dictionary' de la culture internet)";
  $trad['apinbdb_rurl']       = "URL à laquelle se trouve la page";
  $trad['apinbdb_rshorturl']  = "Version courte de l'URL à laquelle se trouve la page";
  $trad['apinbdb_rtitle']     = "Titre de la page";
  $trad['apinbdb_rbody']      = "Contenu de la page";
  $trad['apinbdb_plang']      = "Renvoie les pages dans une langue spécifique ('FR' ou 'EN') - en anglais par défaut";
  $trad['apinbdb_ptype']      = "Renvoie les pages d'un type spécifique ('encyclopedia' ou 'dictionary' ou 'both')";
  $trad['apinbdb_ptitle']     = "Renvoie les titres contenant une chaîne de caractères spécifique";
  $trad['apinbdb_psearch']    = "Renvoie les pages dont le contenu contient une chaîne de caractères spécifique";
  $trad['apinbdb_exemples']   = <<<EOD
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/nbdb</span> - Renvoie toutes les pages<br>
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/nbdb?lang=FR</span> - Renvoie toutes les pages, en français<br>
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/nbdb?lang=EN&type=dictionary</span> - Renvoie toutes les pages du dico de la culture web, en anglais<br>
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/nbdb?title=hog&search=cochonou</span> - Les pages ayant 'hog' dans le titre et contenant 'cochonou'
EOD;

  // Miscellanées
  $trad['apimisc_titre']      = "Miscellanées (citations)";
  $trad['apimisc_tri']        = <<<EOD
Les données sont renvoyées <span class="gras">triées par timestamp</span>, par ordre antéchronologique (<span class="gras">du plus récent au plus ancien</span>).
EOD;
  $trad['apimisc_qid']        = "ID unique de la citation";
  $trad['apimisc_qurl']       = "URL à laquelle se trouve la citation";
  $trad['apimisc_qshorturl']  = "Version courte de l'URL à laquelle se trouve la citation";
  $trad['apimisc_timestamp']  = "Date d'ajout de la citation, sous forme d'un timestamp UNIX";
  $trad['apimisc_langue']     = "Langue de la citation";
  $trad['apimisc_contenu']    = "Contenu de la citation";
  $trad['apimisc_nsfw']       = "Si true, la citation est NSFW (contient du contenu vulgaire ou sensible)";
  $trad['apimisc_id']         = "Renvoie une citation spécifique";
  $trad['apimisc_lang']       = "Renvoie les citations dans une langue spécifique ('FR' ou 'EN')";
  $trad['apimisc_search']     = "Renvoie les citations contenant la chaîne de caractères";
  $trad['apimisc_exemples']   = <<<EOD
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/quotes</span> - Renvoie toutes les miscellanées<br>
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/quotes?id=14</span> - Renvoie uniquement la miscellanée #14<br>
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/quotes?lang=FR&search=Paris</span> - Renvoie les miscellanées en français contenant "Paris"
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']              = "NoBleme's public API";
  $trad['soustitre']          = "For developers who want to take it a step further";
  $trad['desc']               = <<<EOD
NoBleme has a public <a class="gras" href="https://en.wikipedia.org/wiki/Application_programming_interface">API</a>: a way to send queries to NoBleme.com which the website will answer in a standardized format. This allows external programs or apps to use data from NoBleme without having to painfully scrape the contents of the website. This page is aimed at developers who know what they are doing: if you don't understand what an API is, then you probably won't get any use from the contents of this page.
EOD;
  $trad['desc2']              = <<<EOD
NoBleme's API is read only: you can send queries for it to list website contents, but you can't query for it to edit or delete anything on the website. Furthermore, it is a strictly public API, which means that you don't have to authenticate yourself to query the API, but also that this API is limited to public data - you can't ask it for private contents linked to your account.
EOD;
  $trad['desc3']              = <<<EOD
Below, you will find a complete documentation of all the areas of the website that you can query through NoBleme's public API, along with some basic usage examples for each of them. The data sent back by the API is always an <span class="gras">array of JSON objects</span>. In the event that a query to the API yields no results, it will not send an array of JSON objects, but instead will throw a <span class="gras">404 error</span>.
EOD;

  // Données communes
  $trad['api_renvoi']         = "Returned data:";
  $trad['api_params']         = "Available parameters:";
  $trad['api_champ']          = "FIELD";
  $trad['api_type']           = "TYPE";
  $trad['api_contenu']        = "CONTENTS";
  $trad['api_param']          = "PARAMETER";
  $trad['api_importance']     = "IMPORTANCE";
  $trad['api_desc']           = "DESCRIPTION";
  $trad['api_optionnel']      = "Optional";
  $trad['api_exemples']       = "Usage examples:";

  // Encyclopédie de la culture web
  $trad['apinbdb_titre']      = "Encyclopedia of internet culture";
  $trad['apinbdb_tri']        = <<<EOD
The pages are returned <span class="gras">sorted by title</span>, in alphabetical order.
EOD;
  $trad['apinbdb_ruuid']      = "A unique identifier, unrelated to the entry";
  $trad['apinbdb_rtype']      = "Type of entry ('encyclopedia' or 'dictionary' of internet culture)";
  $trad['apinbdb_rurl']       = "URL at which the entry can be found";
  $trad['apinbdb_rshorturl']  = "Short version of the URL at which the entry can be found";
  $trad['apinbdb_rtitle']     = "Title of the entry";
  $trad['apinbdb_rbody']      = "Body of the entry";
  $trad['apinbdb_plang']      = "Returns entries in a specific language ('EN' or 'FR') - defaults to english if not set";
  $trad['apinbdb_ptype']      = "Returns entries of a specific type ('encyclopedia' or 'dictionary' or 'both')";
  $trad['apinbdb_ptitle']     = "Searches entries titles for a specific string";
  $trad['apinbdb_psearch']    = "Searches entries contents for a specific string";
  $trad['apinbdb_exemples']   = <<<EOD
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/nbdb</span> - Returns all entries<br>
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/nbdb?lang=FR</span> - Returns all entries, in french<br>
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/nbdb?lang=EN&type=dictionary</span> - Returns all entries of the dictionary of internet culture, in english<br>
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/nbdb?title=hog&search=piggo</span> - Returns all entries containing 'hog' in the title and 'piggo' in the body
EOD;

  // Miscellanées
  $trad['apimisc_titre']      = "Miscellanea (quotes)";
  $trad['apimisc_tri']        = <<<EOD
The quotes are returned <span class="gras">sorted by timestamp</span>, in reverse chronological order (<span class="gras">most recent first</span>).
EOD;
  $trad['apimisc_qid']        = "Unique quote ID";
  $trad['apimisc_qurl']       = "URL at which the quote can be found";
  $trad['apimisc_qshorturl']  = "Short version of the URL at which the quote can be found";
  $trad['apimisc_timestamp']  = "Date at which the quote was added, as an UNIX timestamp";
  $trad['apimisc_langue']     = "Language of the quote";
  $trad['apimisc_contenu']    = "Contents of the quote";
  $trad['apimisc_nsfw']       = "If true, the quote is NSFW (contains crude or sensitive things)";
  $trad['apimisc_id']         = "Returns a specific quote";
  $trad['apimisc_lang']       = "Returns quotes in a specific language ('EN' or 'FR')";
  $trad['apimisc_search']     = "Returns quotes containing a specific string";
  $trad['apimisc_exemples']   = <<<EOD
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/quotes</span> - Returns all quotes<br>
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/quotes?id=349</span> - Returns only quote #349<br>
<span class="texte_noir gras">{$GLOBALS['url_site']}api/v1/quotes?lang=EN&search=phone</span> - Returns all english quotes containing "Phone"
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <p><?=$trad['desc']?></p>

        <p><?=$trad['desc2']?></p>

        <p><?=$trad['desc3']?></p>

      </div>

      <br>
      <br>

      <hr class="separateur_contenu">

      <br>
      <br>

      <div class="texte2">

        <h4>
          <a href="<?=$chemin?>pages/nbdb/web"><?=$trad['apinbdb_titre']?></a>
        </h4>

        <p>
          <pre onclick="highlight('pre_complet');" class="spaced moinsgros gras texte_noir" id="pre_complet" style="max-height:300px"><?=$GLOBALS['url_site']?>api/v1/nbdb</pre>
        </p>

        <br>

        <h6 class="moinsgros souligne"><?=$trad['api_renvoi']?></h6>

        <p><?=$trad['apinbdb_tri']?></p>

        <br>

        <table class="fullgrid indiv">

          <thead>
            <tr class="grisclair texte_noir gras">
              <th>
                <?=$trad['api_champ']?>
              </th>
              <th>
                <?=$trad['api_type']?>
              </th>
              <th>
                <?=$trad['api_contenu']?>
              </th>
            </tr>
          </thead>

          <tbody>

            <tr>
              <td class="texte_noir gras">
                uuid
              </td>
              <td class="align_center spaced">
                ID
              </td>
              <td>
                <?=$trad['apinbdb_ruuid']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                type
              </td>
              <td class="align_center spaced">
                STRING
              </td>
              <td>
                <?=$trad['apinbdb_rtype']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                url
              </td>
              <td class="align_center spaced">
                STRING
              </td>
              <td>
                <?=$trad['apinbdb_rurl']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                shorturl
              </td>
              <td class="align_center spaced">
                STRING
              </td>
              <td>
                <?=$trad['apinbdb_rshorturl']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                title
              </td>
              <td class="align_center spaced">
                STRING
              </td>
              <td>
                <?=$trad['apinbdb_rtitle']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                contents
              </td>
              <td class="align_center spaced">
                STRING
              </td>
              <td>
                <?=$trad['apinbdb_rbody']?>
              </td>
            </tr>

          </tbody>
        </table>

        <br>
        <br>

        <h6 class="moinsgros souligne"><?=$trad['api_params']?></h6>

        <br>

        <table class="fullgrid indiv">

          <thead>
            <tr class="grisclair texte_noir gras">
              <th>
                <?=$trad['api_param']?>
              </th>
              <th>
                <?=$trad['api_importance']?>
              </th>
              <th>
                <?=$trad['api_desc']?>
              </th>
            </tr>
          </thead>

          <tbody>

            <tr>
              <td class="texte_noir gras">
                lang={string}
              </td>
              <td class="italique align_center spaced">
                <?=$trad['api_optionnel']?>
              </td>
              <td>
                <?=$trad['apinbdb_plang']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                type={string}
              </td>
              <td class="italique align_center spaced">
                <?=$trad['api_optionnel']?>
              </td>
              <td>
                <?=$trad['apinbdb_ptype']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                title={string}
              </td>
              <td class="italique align_center spaced">
                <?=$trad['api_optionnel']?>
              </td>
              <td>
                <?=$trad['apinbdb_ptitle']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                search={string}
              </td>
              <td class="italique align_center spaced">
                <?=$trad['api_optionnel']?>
              </td>
              <td>
                <?=$trad['apinbdb_psearch']?>
              </td>
            </tr>

          </tbody>
        </table>

        <br>
        <br>

        <h6 class="moinsgros souligne"><?=$trad['api_exemples']?></h6>

        <p><?=$trad['apinbdb_exemples']?></p>

      </div>

      <br>
      <br>

      <hr class="separateur_contenu">

      <br>
      <br>

      <div class="texte2">

        <h4>
          <a href="<?=$chemin?>pages/quotes/index"><?=$trad['apimisc_titre']?></a>
        </h4>

        <p>
          <pre onclick="highlight('pre_complet');" class="spaced moinsgros gras texte_noir" id="pre_complet" style="max-height:300px"><?=$GLOBALS['url_site']?>api/v1/quotes</pre>
        </p>

        <br>

        <h6 class="moinsgros souligne"><?=$trad['api_renvoi']?></h6>

        <p><?=$trad['apimisc_tri']?></p>

        <br>

        <table class="fullgrid indiv">

          <thead>
            <tr class="grisclair texte_noir gras">
              <th>
                <?=$trad['api_champ']?>
              </th>
              <th>
                <?=$trad['api_type']?>
              </th>
              <th>
                <?=$trad['api_contenu']?>
              </th>
            </tr>
          </thead>

          <tbody>

            <tr>
              <td class="texte_noir gras">
                id
              </td>
              <td class="align_center spaced">
                INT
              </td>
              <td>
                <?=$trad['apimisc_qid']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                url
              </td>
              <td class="align_center spaced">
                STRING
              </td>
              <td>
                <?=$trad['apimisc_qurl']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                shorturl
              </td>
              <td class="align_center spaced">
                STRING
              </td>
              <td>
                <?=$trad['apimisc_qshorturl']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                timestamp
              </td>
              <td class="align_center spaced">
                INT
              </td>
              <td>
                <?=$trad['apimisc_timestamp']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                lang
              </td>
              <td class="align_center spaced">
                STRING
              </td>
              <td>
                <?=$trad['apimisc_langue']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                text
              </td>
              <td class="align_center spaced">
                STRING
              </td>
              <td>
                <?=$trad['apimisc_contenu']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                nsfw
              </td>
              <td class="align_center spaced">
                BOOL
              </td>
              <td>
                <?=$trad['apimisc_nsfw']?>
              </td>
            </tr>

          </tbody>
        </table>

        <br>
        <br>

        <h6 class="moinsgros souligne"><?=$trad['api_params']?></h6>

        <br>

        <table class="fullgrid indiv">

          <thead>
            <tr class="grisclair texte_noir gras">
              <th>
                <?=$trad['api_param']?>
              </th>
              <th>
                <?=$trad['api_importance']?>
              </th>
              <th>
                <?=$trad['api_desc']?>
              </th>
            </tr>
          </thead>

          <tbody>

            <tr>
              <td class="texte_noir gras">
                id={int}
              </td>
              <td class="italique align_center spaced">
                <?=$trad['api_optionnel']?>
              </td>
              <td>
                <?=$trad['apimisc_id']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                lang={string}
              </td>
              <td class="italique align_center spaced">
                <?=$trad['api_optionnel']?>
              </td>
              <td>
                <?=$trad['apimisc_lang']?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir gras">
                search={string}
              </td>
              <td class="italique align_center spaced">
                <?=$trad['api_optionnel']?>
              </td>
              <td>
                <?=$trad['apimisc_search']?>
              </td>
            </tr>

          </tbody>
        </table>

        <br>
        <br>

        <h6 class="moinsgros souligne"><?=$trad['api_exemples']?></h6>

        <p><?=$trad['apimisc_exemples']?></p>

      </div>

      <br>
      <br>

      <hr class="separateur_contenu">

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';