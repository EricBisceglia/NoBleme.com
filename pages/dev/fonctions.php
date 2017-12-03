<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/forum.inc.php';    // Fonctions liées au forum

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Dev';
$header_sidemenu  = 'Fonctions';

// Titre et description
$page_titre = "Dev: Fonctions";

// Identification
$page_nom = "Administre secrètement le site";

// CSS & JS
$css = array('dev');
$js  = array('toggle', 'highlight', 'dev/reference');





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <table class="fullgrid titresnoirs margin_auto noresize" style="width:1250px;">
        <thead>
          <tr>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onClick="fonctions_tout_fermer();toggle_row('liste_fonctions_texte');">
              TEXTE
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onClick="fonctions_tout_fermer();toggle_row('liste_fonctions_dates');">
              DATES
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onClick="fonctions_tout_fermer();toggle_row('liste_fonctions_maths');">
              MATHS
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onClick="fonctions_tout_fermer();toggle_row('liste_fonctions_users');">
              USERS
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onClick="fonctions_tout_fermer();toggle_row('liste_fonctions_nobleme');">
              NOBLEME
            </th>
            <th class="rowaltc moinsgros pointeur border_all_blank"
                onClick="fonctions_tout_fermer();toggle_row('liste_fonctions_divers');">
              DIVERS
            </th>
          </tr>
        </thead>
      </table>

      <br>
      <br>




<!-- ######################################################################################################################################
#                                                                                                                                         #
#                                                                 TEXTE                                                                   #
#                                                                                                                                         #
###################################################################################################################################### !-->

      <div id="liste_fonctions_texte">

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                CHAÎNES DE CARACTÈRES
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                tronquer_chaine('Héhéhé',4,' [...]');
              </td>
              <td class="gras align_center">
                <?=tronquer_chaine('Héhéhé',4,' [...]');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                changer_casse('Test accentué','maj');
              </td>
              <td class="gras align_center">
                <?=changer_casse('Test accentué','maj');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                changer_casse('TEST ACCENTUÉ','min');
              </td>
              <td class="gras align_center">
                <?=changer_casse('TEST ACCENTUÉ','min');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                changer_casse('éssai avec accent','init');
              </td>
              <td class="gras align_center">
                <?=changer_casse('éssai avec accent','init');?>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                BBCODES ET EMOTICÔNES
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                bbcode("on [u]souligne[/u] :)");
              </td>
              <td class="gras align_center">
                <?=bbcode("on [u]souligne[/u] :)");?>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                DIFFÉRENCE ENTRE DEUX TEXTES
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                diff("123 Avant xx", "123 Après xx");
              </td>
              <td class="align_center">
                <?=diff("123 Avant xx", "123 Après xx");?>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                RETOURS CHARIOTS
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                br2ln("Des&lt;br&gt;retours&lt;br /&gt;chariot");
              </td>
              <td class="gras align_center">
                <?=br2ln("Des<br>retours<br />chariot");?>
              </td>
            </tr>
          </tbody>
        </table>

      </div>




<!-- ######################################################################################################################################
#                                                                                                                                         #
#                                                                 DATES                                                                   #
#                                                                                                                                         #
###################################################################################################################################### !-->

      <div class="hidden" id="liste_fonctions_dates">

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                DATES EN TOUTES LETTRES
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                $joursfr[2]
              </td>
              <td class="gras align_center">
                <?=$joursfr[2];?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                $moisfr[2]
              </td>
              <td class="gras align_center">
                <?=$moisfr[2];?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                $moisfr_courts[2]
              </td>
              <td class="gras align_center">
                <?=$moisfr_courts[2];?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                $datefr
              </td>
              <td class="gras align_center">
                <?=$datefr;?>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                CONVERSION DE DATES MYSQL
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                datefr('2005-03-19');
              </td>
              <td class="gras align_center">
                <?=datefr('2005-03-19');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                datefr('2005-03-19', 'EN');
              </td>
              <td class="gras align_center">
                <?=datefr('2005-03-19', 'EN');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                jourfr('2005-03-19', 'FR');
              </td>
              <td class="gras align_center">
                <?=jourfr('2005-03-19', 'FR');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                jourfr('2005-03-19', 'EN');
              </td>
              <td class="gras align_center">
                <?=jourfr('2005-03-19', 'EN');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                jourfr('2005-03-19', 'FR', 1);
              </td>
              <td class="gras align_center">
                <?=jourfr('2005-03-19', 'FR', 1);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                jourfr('2005-03-19', 'EN', 1);
              </td>
              <td class="gras align_center">
                <?=jourfr('2005-03-19', 'EN', 1);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                ddmmyy('2005-03-19');
              </td>
              <td class="gras align_center">
                <?=ddmmyy('2005-03-19');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                ddmmyy('0000-00-00');
              </td>
              <td class="gras align_center">
                <?=ddmmyy('0000-00-00');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                mysqldate('19/03/2005');
              </td>
              <td class="gras align_center">
                <?=mysqldate('19/03/2005');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                mysqldate('19/03/05');
              </td>
              <td class="gras align_center">
                <?=mysqldate('19/03/05');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                mysqldate('13/14/15');
              </td>
              <td class="gras align_center">
                <?=mysqldate('13/14/15');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                mysqldate('Ceci n\'est pas une date');
              </td>
              <td class="gras align_center">
                <?=mysqldate('Ceci n\'est pas une date');?>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                DÉLAI D'UN TIMESTAMP
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                ilya(strtotime('2005-03-19'));
              </td>
              <td class="gras align_center">
                <?=ilya(strtotime('2005-03-19'));?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                ilya(strtotime('2005-03-19'), 'EN');
              </td>
              <td class="gras align_center">
                <?=ilya(strtotime('2005-03-19'), 'EN');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                ilya(time());
              </td>
              <td class="gras align_center">
                <?=ilya(time());?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                dans(strtotime((date('Y')+1).date('-m-d')));
              </td>
              <td class="gras align_center">
                <?=dans(strtotime((date('Y')+1).date('-m-d')));?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                dans(strtotime((date('Y')+1).date('-m-d')), 'EN');
              </td>
              <td class="gras align_center">
                <?=dans(strtotime((date('Y')+1).date('-m-d')), 'EN');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                dans(time()-1);
              </td>
              <td class="gras align_center">
                <?=dans(time()-1);?>
              </td>
            </tr>
          </tbody>
        </table>

      </div>




<!-- ######################################################################################################################################
#                                                                                                                                         #
#                                                                 MATHS                                                                   #
#                                                                                                                                         #
###################################################################################################################################### !-->

      <div class="hidden" id="liste_fonctions_maths">

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                SIGNE D'UN NOMBRE
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                signe_nombre(1);
              </td>
              <td class="gras align_center">
                <?=signe_nombre(1);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                format_positif(0);
              </td>
              <td class="gras align_center">
                <?=format_positif(0);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                format_positif(-1,'hex');
              </td>
              <td class="gras align_center" style="color:#<?=format_positif(-1,'hex');?>">
                <?=format_positif(-1,'hex');?>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                FORMATTAGE DES NOMBRES
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                format_nombre(1234567, "nombre");
              </td>
              <td class="gras align_center">
                <?=format_nombre(1234567, "nombre");?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                format_nombre(1000000, "prix");
              </td>
              <td class="gras align_center">
                <?=format_nombre(1000000, "prix");?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                format_nombre(1337.42, "centimes");
              </td>
              <td class="gras align_center">
                <?=format_nombre(1337.42, "centimes");?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                format_nombre(12.3, "pourcentage",2);
              </td>
              <td class="gras align_center">
                <?=format_nombre(12.3, "pourcentage",2);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                format_nombre(3, "point", NULL, "signed");
              </td>
              <td class="gras align_center">
                <?=format_nombre(3, "point", NULL, "signed");?>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                CALCUL D'UN POURCENTAGE
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                calcul_pourcentage(42,69);
              </td>
              <td class="gras align_center">
                <?=calcul_pourcentage(42,69);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                format_nombre(calcul_pourcentage(1,4),"pourcentage",0);
              </td>
              <td class="gras align_center">
                <?=format_nombre(calcul_pourcentage(1,4),"pourcentage",0);?>
              </td>
            </tr>
          </tbody>
        </table>

      </div>




<!-- ######################################################################################################################################
#                                                                                                                                         #
#                                                                 USERS                                                                   #
#                                                                                                                                         #
###################################################################################################################################### !-->

      <div class="hidden" id="liste_fonctions_users">

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                PERMISSIONS
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                guestonly($lang);
              </td>
              <td class="align_center">
                Vire les utilisateurs connectés
              </td>
            </tr>
            <tr>
              <td class="align_center">
                useronly($lang);
              </td>
              <td class="align_center">
                Vire les visiteurs non connectés
              </td>
            </tr>
            <tr>
              <td class="align_center">
                sysoponly($lang);
              </td>
              <td class="align_center">
                Vire ceux qui ne sont pas sysop
              </td>
            </tr>
            <tr>
              <td class="align_center">
                sysoponly($lang, 'forum');
              </td>
              <td class="align_center">
                Vire ceux qui sont ni sysop ni modérateur de la zone
              </td>
            </tr>
            <tr>
              <td class="align_center">
                adminonly($lang);
              </td>
              <td class="align_center">
                Vire ceux qui ne sont pas admin
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                INFOS SUR LE COMPTE
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                loggedin();
              </td>
              <td class="gras align_center">
                <?=loggedin();?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                getpseudo();
              </td>
              <td class="gras align_center">
                <?=getpseudo();?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                getpseudo(42);
              </td>
              <td class="gras align_center">
                <?=getpseudo(42);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                getmod('irl');
              </td>
              <td class="gras align_center">
                <?=getmod('irl');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                getmod('irl',227);
              </td>
              <td class="gras align_center">
                <?=getmod('irl',227);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                getsysop();
              </td>
              <td class="gras align_center">
                <?=getsysop();?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                getsysop(42);
              </td>
              <td class="gras align_center">
                <?=getsysop(42);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                getadmin();
              </td>
              <td class="gras align_center">
                <?=getadmin();?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                getadmin(42);
              </td>
              <td class="gras align_center">
                <?=getadmin(42);?>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                GESTION DE LA CONNEXION
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                logout();
              </td>
              <td class="align_center">
                Déconnexion
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros">
                NOTIFICATIONS / MESSAGES PRIVÉS
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                envoyer_notif(42, 'Message de Bad', 'Corps du message', 1);
              </td>
            </tr>
            <tr>
              <td class="align_center">
                envoyer_notif(69, 'Messge système', 'Apparait comme envoyé par le système');
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                SALAGE DE MOT DE PASSE
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                salage('mot de passe');
              </td>
              <td class="gras align_center">
                <?=salage('mot de passe');?>
              </td>
            </tr>
          </tbody>
        </table>

      </div>




<!-- ######################################################################################################################################
#                                                                                                                                         #
#                                                                NOBLEME                                                                  #
#                                                                                                                                         #
###################################################################################################################################### !-->

      <div class="hidden" id="liste_fonctions_nobleme">

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros">
                ENVOI D'UN MESSAGE SUR IRC VIA LE BOT
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                ircbot($chemin,"Message à poster sur dev","#dev");
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                IMPORTANCE D'UNE TÂCHE
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                todo_importance(5);
              </td>
              <td class="align_center">
                <?=todo_importance(5);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                todo_importance(5,1);
              </td>
              <td class="align_center">
                <?=todo_importance(5,1);?>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                SURNOMS MIGNONS ALÉATOIRES
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                surnom_mignon();<br>
                surnom_mignon();<br>
                surnom_mignon();<br>
                surnom_mignon();
              </td>
              <td class="gras align_center">
                <?=surnom_mignon();?><br>
                <?=surnom_mignon();?><br>
                <?=surnom_mignon();?><br>
                <?=surnom_mignon();?>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                CLASSIFICATION D'UN SUJET DE DISCUSSION DU FORUM
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                forum_option_info('Anonyme', 'complet', 'FR');
              </td>
              <td class="gras align_center">
                <?=forum_option_info('Anonyme', 'complet', 'FR');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                forum_option_info('Sérieux', 'court', 'EN');
              </td>
              <td class="gras align_center">
                <?=forum_option_info('Sérieux', 'court', 'EN');?>
              </td>
            </tr>
          </tbody>
        </table>

      </div>



<!-- ######################################################################################################################################
#                                                                                                                                         #
#                                                                 DIVERS                                                                  #
#                                                                                                                                         #
###################################################################################################################################### !-->

      <div class="hidden" id="liste_fonctions_divers">

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros">
                REQUÊTE SQL
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                query("SELECT * FROM table WHERE 1=1");
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                NETTOYAGE DU HTML
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                predata("string&lt;hr&gt;HTML");
              </td>
              <td class="align_center">
                <?=predata("string<hr>HTML");?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                predata("string&lt;hr&gt;<br>
                Retour chariot",1);
              </td>
              <td class="align_center">
                <?=predata("string<hr>
                Retour chariot",1);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                destroy_html('&lt;balise onclick="xss"&gt;');
              </td>
              <td class="align_center">
                <?=destroy_html('<balise onclick="xss">');?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                destroy_html(":amp:");
              </td>
              <td class="align_center">
                <?=destroy_html(":amp:");?>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                ASSAINISSEMENT DU POSTDATA
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                postdata("hel'lo");
              </td>
              <td class="align_center">
                <?=postdata("hel'lo");?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                postdata("whitespace           ");
              </td>
              <td class="align_center">
                <?=postdata("whitespace           ");?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                postdata("string","int");
              </td>
              <td class="align_center">
                <?=postdata("string","int");?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                postdata(123.456,"int");
              </td>
              <td class="align_center">
                <?=postdata(123.456,"int");?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                postdata(-999.9999,"double",-500.001,500.001);
              </td>
              <td class="align_center">
                <?=postdata(-999.9999,"double",-500.001,500.001);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                postdata(999,"double",-500,500);
              </td>
              <td class="align_center">
                <?=postdata(999,"double",-500,500);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                postdata("longue p'hrase","string",0,10);
              </td>
              <td class="align_center">
                <?=postdata("longue p'hrase","string",0,10);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                postdata("courte p'hrase","string",20);
              </td>
              <td class="align_center">
                <?=postdata("courte p'hrase","string",20);?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                postdata_vide("mon_postdata", "string", "rien");
              </td>
              <td class="align_center">
                <?=postdata_vide("mon_postdata", "string", "rien");?>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                postdata_vide("texte", "string", "", 4, '...');
              </td>
              <td class="align_center">
                text...
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros">
                PAGE D'ERREUR
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                erreur("On arrête tout (à placer avant le header)");
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros">
                PAGE NE POUVANT QUE ÊTRE APPELÉE PAR DYNAMIQUE()
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                xhronly();
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                DEBUG EN PROD
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                bfdecho("Seul Bad peut voir ceci");
              </td>
              <td class="gras align_center">
                <?=bfdecho("Seul Bad peut voir ceci");?>
              </td>
            </tr>
          </tbody>
        </table>

      </div>




<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';