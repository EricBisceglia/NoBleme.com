<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Dev';
$header_sidemenu  = 'MajFermeture';

// Titre et description
$page_titre = "Dev: Ouvrir/fermer le site";

// Identification
$page_nom = "Administre secrètement le site";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Ouvrir le site
if(isset($_GET['ouvrir']))
  query(" UPDATE vars_globales SET mise_a_jour = 0 ");

// Fermer le site
else if(isset($_GET['fermer']))
  query(" UPDATE vars_globales SET mise_a_jour = 1 ");




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher si le site est ouvert ou fermé
$qfermeture = mysqli_fetch_array(query(" SELECT mise_a_jour FROM vars_globales "));

// On prépare les données pour l'affichage
if(!$qfermeture['mise_a_jour'])
{
  $fermeture_css    = "positif texte_blanc";
  $fermeture_etat   = "Le site est actuellement ouvert";
  $fermeture_url    = "fermeture?fermer";
  $fermeture_action = "FERMER LE SITE";
}
else
{
  $fermeture_css    = "negatif texte_blanc";
  $fermeture_etat   = "Le site est actuellement fermé";
  $fermeture_url    = "fermeture?ouvrir";
  $fermeture_action = "OUVRIR LE SITE";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <br>
      <br>
      <br>
      <br>
      <br>
      <br>

      <div class="texte">

        <h1 class="align_center <?=$fermeture_css?>"><?=$fermeture_etat?></h1>

        <br>
        <br>
        <br>
        <br>
        <br>

        <h1 class="align_center">
          <a href="<?=$chemin?>pages/dev/<?=$fermeture_url?>">
            <?=$fermeture_action?>
          </a>
        </h1>

      </div>

      <br>
      <br>
      <br>
      <br>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';