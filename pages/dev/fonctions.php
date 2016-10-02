<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'admin';
$header_submenu   = 'dev';
$header_sidemenu  = 'fonctions';

// Titre
$page_titre = "Dev : Fonctions";

// Identification
$page_nom = "admin";

// CSS & JS
$css = array('admin');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>

    <div class="margin_auto css_couleurs monospace">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_sous_titre gros">LÉGENDE DES COULEURS</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center vert_background gras">Fonction sécurisée et bonne à utiliser</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center mise_a_jour_background gras">Fonction dépréciée et/ou dangereuse, à éviter</td>
        </tr>

      </table>
    </div>

    <br>
    <br>

    <div class="margin_auto midsize monospace">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">INDEX NAVIGATION RAPIDE</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros pointeur" onClick="window.location.hash='#sql';">
            Fonctions SQL
          </td>
          <td class="cadre_gris_sous_titre moinsgros pointeur" onClick="window.location.hash='#dates';">
            Dates
          </td>
          <td class="cadre_gris_sous_titre moinsgros pointeur" onClick="window.location.hash='#users';">
            Utilisateurs et permissions
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros pointeur" onClick="window.location.hash='#post';">
            Post-traitement
          </td>
          <td class="cadre_gris_sous_titre moinsgros pointeur" onClick="window.location.hash='#sessions';">
            Sessions
          </td>
          <td class="cadre_gris_sous_titre moinsgros pointeur" onClick="window.location.hash='#nobleme';">
            Fonctionnalités du site
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros pointeur" onClick="window.location.hash='#formattage';">
            Formattage
          </td>
          <td class="cadre_gris_sous_titre moinsgros pointeur" onClick="window.location.hash='#debug';">
            Debug
          </td>
          <td class="cadre_gris_sous_titre moinsgros pointeur" onClick="window.location.hash='#conneries';">
            Conneries
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto monospace css_sections" id="sql">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            FONCTIONS SQL
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">
            Fonction
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Description
          </td><td class="cadre_gris_sous_titre moinsgros">
            Exemple
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>query(</b>"requête"<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Requête SQL basique, prend la requête entière en paramètre
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $q = query(" SELECT * FROM table ");
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto monospace css_sections" id="post">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            POST-TRAITEMENT DES DONNÉES
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">
            Fonction
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Description
          </td><td class="cadre_gris_sous_titre moinsgros">
            Exemple
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>postdata(</b>$_POST['data']<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Nettoie le postdata pour éviter les injections SQL
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $champ = postdata($_POST['champ']);
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>postdata_vide(</b>'data'<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Similaire à postdata(), mais renvoie '' si le post n'existe pas
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $champ = postdata_vide('champ');
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>postdata_vide_defaut(</b>'data',defaut<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Similaire à postdata_vide(),<br>mais assigne la valeur par défaut si le post n'existe pas
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $champ = postdata_vide_defaut('champ','x');
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap mise_a_jour_background">
            <b>postdata_vide_dangereux(</b>'data'<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced mise_a_jour_background">
            <b>DANGEREUX !</b> Similaire à postdata_vide(),<br> mais ne sanitize pas les données
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap mise_a_jour_background">
            $champ = postdata_vide_dangereux('champ');
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>nl2br_fixed(</b>"contenu"<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            nl2br() ne respecte pas le doctype, sort des &lt;br /> au lieu de &lt;br><br>
            Cette fonction transforme retours à la ligne en &lt;br>
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $texte = nl2br_fixed("abc \r\n xyz");
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>br2ln(</b>"contenu"<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Effet inverse de nl2br et nl2br_fixed<br>
            Cette fonction transforme &lt;br> en retours à la ligne
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $texte = br2ln("abc &lt;br> xyz");
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>meta_fix(</b>"description"<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Remplace les caractères interdits dans les balises meta<br>par leur équivalent htmlentities
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $meta = meta_fix("Description][meta");
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>destroy_html(</b>"string"<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Détruit les tags html pour ne pas se faire xss<br>Transforme également les :amp: en &amp; pour gérer les retours du XHR
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $string = destroy_html($contenu_html);
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto monospace css_sections" id="users">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            GESTION DES UTILISATEURS
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">
            Fonction
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Description
          </td><td class="cadre_gris_sous_titre moinsgros">
            Exemple
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>adminonly()</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Empêche de voir la page si l'user n'est pas un admin
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            adminonly();
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>sysoponly()</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Empêche de voir la page si l'user n'est pas un sysop
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            sysoponly();
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>useronly()</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Empêche de voir la page si l'user est un invité, requiert un compte
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            useronly();
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>guestonly()</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Empêche de voir la page si l'user est enregistré, invités uniquement
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            guestonly();
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>loggedin()</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Renvoie TRUE si l'utilisateur est connecté, sinon FALSE
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            if(loggedin()){ action(); }
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>getsysop(</b>userid<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Renvoie 1 si l'userid rentré est un sysop, sinon renvoie 0<br>
            Si le paramètre est NULL, renvoie le pseudonyme de l'user actuel
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            if getsysop($_SESSION['user']){ action(); }<br>
            if getsysop(){ action(); }
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>getadmin(</b>userid<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Renvoie 1 si l'userid rentré est un admin, sinon renvoie 0<br>
            Si le paramètre est NULL, renvoie le pseudonyme de l'user actuel
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            if getadmin($_SESSION['user']){ action(); }<br>
            if getadmin(){ action(); }
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>getpseudo(</b>userid<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Renvoie le pseudonyme correspondant à l'userid rentré<br>
            Si le paramètre est NULL, renvoie le pseudonyme de l'user actuel
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $nick = getpseudo($_SESSION['user']);<br>
            $nick = getpseudo();
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap mise_a_jour_background">
            <b>logout()</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced mise_a_jour_background">
            Déconnecte l'user, détruit également son cookie
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap mise_a_jour_background">
            logout();
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>salage(</b>"pass"<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Hashage et salage du mot de passe<br>
            Sha-512 avec saltage, largement assez sécurisé pour les années à venir
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $hash = salage("motdepasse");
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap mise_a_jour_background">
            <b>old_salage(</b>"pass"<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced mise_a_jour_background">
            Hashage et salage du mot de passe, déprécié<br>
            Utilise la vieille méthode de vbulletin qui est une variante de md5<br>
            Sert à changer en salage() les users qui ne sont pas venus depuis des plombes
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap mise_a_jour_background">
            $hash = old_salage("motdepasse");
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto monospace css_sections" id="nobleme">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            FONCTIONNALITÉS DU SITE
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">
            Fonction
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Description
          </td><td class="cadre_gris_sous_titre moinsgros">
            Exemple
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>erreur(</b>"message"<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Envoie un message d'erreur et exit() la page actuelle<br>
            La page d'erreur contient le header et footer, ne bloque pas la navigation
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            erreur("gtfo");
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>envoyer_notif(</b>destinataire,<br>"titre","contenu",sender,silent<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Envoie une notification<br>
            Le champ destinataire est un userid<br>
            Si sender est NULL, alors la notif sera un message système<br>
            Si silent est set, alors le message sera considéré comme déjà lu<br>
            Les retours à la ligne sont à faire sous forme \r\n
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            envoyer_notif(1,"Sup!","Line\r\nBreak");<br>
            envoyer_notif($user,"Shh","Silent",1,1);
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>ircbot(</b>$chemin,"texte","canal"<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Envoie une commande au bot IRC NoBleme<br>
            $chemin doit être le $chemin usuel<br>
            Canal doit contenir le nom du canal entier, avec le #<br>
            Si canal est NULL, le message brut sera envoyé
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            ircbot($chemin,"Bonjour !","#NoBleme");<br>
            ircbot($chemin,"NICK NouveauPseudo");
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>bbcode(</b>data<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Transforme les bbcodes et emotes du contenu en html
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            bbcode('[b]gras[/b]');
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>todo_importance(</b>valeur,style<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Renvoie un ordre de priorité à partir d'une valeur entre 0 et 5<br>
            Utilisé pour la liste des tâches<br>
            Si style est set, renvoie du HTML en plus du texte<br>
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            todo_importance($valeur);<br>
            todo_importance($todo,1)
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto monospace css_sections" id="dates">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            GESTION DES DATES
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">
            Fonction
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Description
          </td><td class="cadre_gris_sous_titre moinsgros">
            Exemple
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>datefr(</b>date<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Transforme une date mysql en une date en toutes lettres<br>
            Aujourd'hui (<?=date('Y-m-d')?>) en datefr() est le <?=datefr(date('Y-m-d'))?>
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $date = datefr(date('Y-m-d'));
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>jourfr(</b>date<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Similaire à datefr, mais ne renvoie pas le nom du jour<br>
            Aujourd'hui (<?=date('Y-m-d')?>) en jourfr() est le <?=jourfr(date('Y-m-d'))?><br>
            Un paramètre optionnel permet de ne pas spécifier le jour avant la date
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $date = jourfr(date('Y-m-d'));<br>
            $date = jourfr('2005-19-03',1);
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>ddmmyy(</b>date<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Transforme une date mysql en date au format dd/mm/yy<br>
            Aujourd'hui (<?=date('Y-m-d')?>) en ddmmyy() est le <?=ddmmyy(date('Y-m-d'))?>
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $date = ddmmyy(date('Y-m-d'));
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>ilya(</b>timestamp<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Renvoie en toutes lettres le temps écoulé entre le timestamp et maintenant
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $anciennete = ilya($timestamp);
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>dans(</b>timestamp<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Renvoie en toutes lettres le temps restant entre maintenant et le timestamp
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $reste = dans($timestamp);
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto monospace css_sections" id="formattage">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            FORMATTAGE
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">
            Fonction
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Description
          </td><td class="cadre_gris_sous_titre moinsgros">
            Exemple
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>diff_raw()</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Fonction servant au fonctionnement de diff()<br>
            Prend deux arrays en param, renvoie un array des différences<br>
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            -----
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>diff()</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Renvoie les différences entre deux strings<br>
            Utilise les tags html ins et del pour formatter le résultat<br>
            Le troisième paramètre optionnel renvoie du bbcode au lieu de html<br>
            Le quatrième paramètre optionnel renvoie les résultats dans un joli tableau<br>
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            diff("avant","apres",0,1);
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>


    <div class="margin_auto monospace css_sections" id="sessions">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            SESSIONS PHP
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">
            Fonction
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Description
          </td><td class="cadre_gris_sous_titre moinsgros">
            Exemple
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>session_start_securise()</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Bouche des trous de sécurités du session_start() de PHP<br>
            Régénère le token à chaque page load pour le rendre plus chiant à spoofer<br>
            Passe uniquement par un cookie de session pour minimiser les routes de fuite<br>
            Spawne un cookie de session qui ne se laisse pas poller par le javascript<br>
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            session_start_securise();
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto monospace css_sections" id="conneries">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            CONNERIES
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">
            Fonction
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Description
          </td><td class="cadre_gris_sous_titre moinsgros">
            Exemple
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap vert_background">
            <b>surnom_mignon()</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced vert_background">
            Génère un surnom mignon aléatoire, utilisé pour identifier les invités<br>
            Exemple: <?=surnom_mignon()?>
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap vert_background">
            $nom_invite = surnom_mignon();
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto monospace css_sections" id="debug">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            FONCTIONS DE DEBUG
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">
            Fonction
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Description
          </td><td class="cadre_gris_sous_titre moinsgros">
            Exemple
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_right spaced nowrap mise_a_jour_background">
            <b>bfdecho(</b>"valeur"<b>)</b>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center spaced mise_a_jour_background">
            Affiche du texte que seul Bad peut voir<br>
            À n'utiliser que dans les cas extrêmes, pour debug en prod
          </td>
          <td class="cadre_gris cadre_gris_haut align_left italique spaced nowrap mise_a_jour_background">
            bfdecho($debug);
          </td>
        </tr>

      </table>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';