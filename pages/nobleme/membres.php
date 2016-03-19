<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Liste des membres";
$page_desc  = "Liste des utilisateurs inscrits sur NoBleme";

// Identification
$page_nom = "nobleme";
$page_id  = "membres";

// JS
$js = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On se récupère tous les membres
$qmembres = "     SELECT    membres.id            ,
                            membres.pseudonyme    ,
                            membres.admin         ,
                            membres.sysop         ,
                            membres.date_creation ,
                            membres.derniere_visite
                  FROM      membres               ";

// Recherche
if(isset($_POST['search_membre']))
{
  $search_membre = postdata_vide('search_membre');
  $qmembres .= "  WHERE     membres.pseudonyme LIKE '%$search_membre%' ";
}

// Ordre de tri
$sortpseudo   = 'up';
$sortregister = 'down';
$sortactive   = 'down';
if(isset($_POST['sortpseudo']))
{
  $sortpseudo = postdata_vide('sortpseudo');
  if($sortpseudo == 'up')
  {
    $sortpseudo = 'down';
    $qmembres .= "  ORDER BY  membres.pseudonyme ASC ";
  }
  else
  {
    $sortpseudo = 'up';
    $qmembres .= "  ORDER BY  membres.pseudonyme DESC ";
  }
}
else if(isset($_POST['sortregister']))
{
  $sortregister = postdata_vide('sortregister');
  if($sortregister == 'up')
  {
    $sortregister = 'down';
    $qmembres .= "  ORDER BY  membres.date_creation ASC ";
  }
  else
  {
    $sortregister = 'up';
    $qmembres .= "  ORDER BY  membres.date_creation DESC ";
  }
}
else if(isset($_POST['sortactive']))
{
  $sortactive = postdata_vide('sortactive');
  if($sortactive == 'up')
  {
    $sortactive = 'down';
    $qmembres .= "  ORDER BY  membres.derniere_visite ASC ";
  }
  else
  {
    $sortactive = 'up';
    $qmembres .= "  ORDER BY  membres.derniere_visite DESC ";
  }
}
else
  $qmembres .= "  ORDER BY  membres.date_creation DESC ";

// Balançons la requête
$qmembres = query($qmembres);

// Préparation des données
for($nmembres = 0 ; $dmembres = mysqli_fetch_array($qmembres) ; $nmembres++)
{
  $m_id[$nmembres]      = $dmembres['id'];
  $m_pseudo[$nmembres]  = $dmembres['pseudonyme'];
  $m_inscr[$nmembres]   = ilya($dmembres['date_creation']);
  $m_visite[$nmembres]  = ilya($dmembres['derniere_visite']);
  if($dmembres['admin'])
  {
    $m_cssl[$nmembres]  = 'texte_blanc nolink';
    $m_css[$nmembres]   = 'mise_a_jour gras texte_blanc';
  }
  else if($dmembres['sysop'])
  {
    $m_cssl[$nmembres]  = 'texte_blanc nolink';
    $m_css[$nmembres]   = 'sysop gras texte_blanc';
  }
  else if((time() - $dmembres['derniere_visite']) < 2592000)
  {
    $m_css[$nmembres]   = 'nobleme_background gras';
    $m_cssl[$nmembres]  = 'dark blank';
  }
  else
  {
    $m_css[$nmembres]   = '';
    $m_cssl[$nmembres]  = 'dark blank';
  }
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])) { /* Ne pas afficher les données dynamiques dans la page normale */ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/liste_membres.png" alt="Liste des membres">
    </div>
    <br>

    <div class="body_main smallsize">
      <span class="titre">Utilisateurs inscrits sur NoBleme</span><br>
      <br>
      Le tableau ci-dessous recense toutes les personnes qui se sont inscrites sur NoBleme.<br>
      <br>
      Les membres récemment actifs apparaissent en <span class="gras">gras</span> et sur fond <span class="nobleme_background gras">&nbsp;gris&nbsp;</span>,<br>
      les sysops (modérateurs du site) sur fond <span class="sysop gras texte_blanc">&nbsp;orange&nbsp;</span><br>
      et l'administrateur sur fond <span class="mise_a_jour gras texte_blanc">&nbsp;rouge&nbsp;</span>.<br>
      <br>
      Vous pouvez trier les résultats dans un ordre autre que du plus ancien au plus récent en cliquant sur le titre des colonnes du tableau (par exemple sur "Dernière connexion" pour voir les membres actifs).<br>
      <br>
      Cliquez sur le pseudonyme d'un membre pour voir sa page de profil.<br>
      <br>
      <script type="text/javascript">
        document.write('<br>'); // Cette ruse est pour que la balise noscript qui suive soit validée WC3 :>
      </script>
      <noscript>
        <div class="gros gras align_center erreur texte_blanc intable">
          <br>
          Le JavaScript est désactivé sur votre navigateur.<br>
          <br>
          Le JavaScript doit être activé pour pouvoir utiliser la page !<br>
          <br>
        </div>
        <br>
      </noscript>
      <span class="soustitre">Rechercher un utilisateur</span><br>
      <br>
      <input id="search_membre" class="indiv nobleme_background align_center texte_nobleme_fonce" value="Entrez votre recherche ici"
        onFocus="if(this.value == 'Entrez votre recherche ici'){ this.value = ''; }"
        onKeyUp="dynamique('<?=$chemin?>','membres.php?dynamique','liste_membres','search_membre='+dynamique_prepare('search_membre'))">
    </div>

    <br>

    <div class="body_main smallsize" id="liste_membres">

      <?php } ?>

      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros pointeur"
            onClick="dynamique('<?=$chemin?>','membres.php?dynamique','liste_membres','sortpseudo=<?=$sortpseudo?>');">
            Pseudonyme
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros pointeur"
            onClick="dynamique('<?=$chemin?>','membres.php?dynamique','liste_membres','sortregister=<?=$sortregister?>');">
            Inscription
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros pointeur"
            onClick="dynamique('<?=$chemin?>','membres.php?dynamique','liste_membres','sortactive=<?=$sortactive?>');">
            Dernière connexion
          </td>
        </tr>

        <?php for($i=0;$i<$nmembres;$i++) { ?>

        <tr>
          <td class="cadre_gris align_center <?=$m_css[$i]?>">
            <a class="<?=$m_cssl[$i]?>" href="<?=$chemin?>pages/user/user?id=<?=$m_id[$i]?>"><?=$m_pseudo[$i]?></a>
          </td>
          <td class="cadre_gris align_center <?=$m_css[$i]?>">
            <?=$m_inscr[$i]?>
          </td>
          <td class="cadre_gris align_center <?=$m_css[$i]?>">
            <?=$m_visite[$i]?>
          </td>
        </tr>

        <?php } ?>

      </table>

      <?php if(!isset($_GET['dynamique'])) { ?>

    </div>

<?php include './../../inc/footer.inc.php'; } /*******************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/