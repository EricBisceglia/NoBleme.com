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
$header_sidemenu  = 'MajChecklist';

// Titre et description
$page_titre = "Dev: Mise à jour";

// Identification
$page_nom = "Administre secrètement le site";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h4>Avant de faire une mise à jour:</h4>

        <p>
          <input type="checkbox"> S'il y a eu des changements structurels SQL, faire un dump de la structure dans sqldump.php<br>
          <input type="checkbox"> Si le contenu supprime du contenu dans la BDD, penser à supprimer l'activité et les pageviews liés<br>
          <input type="checkbox"> Passer le rendu HTML du nouveau contenu au <a href="https://validator.w3.org/#validate_by_input">validateur W3C</a><br>
          <input type="checkbox"> Tester les permissions du nouveau contenu en tant que invité, user, mod, sysop, admin<br>
          <input type="checkbox"> Vérifier que les nouvelles pages apparaissent bien dans <a href="<?=$chemin?>pages/nobleme/online">qui est en ligne</a><br>
          <input type="checkbox"> Est-ce que le nouveau contenu génére bien des logs dans l'<a href="<?=$chemin?>pages/nobleme/activite">activité recente</a> et les <a href="<?=$chemin?>pages/nobleme/activite?mod">logs de modération</a><br>
          <input type="checkbox"> Est-ce que le nouveau contenu génère des alertes via le <a href="<?=$chemin?>pages/dev/ircbot">bot IRC NoBleme</a><br>
          <input type="checkbox"> Est-ce que les nouveaux raccourcis ont bien été ajoutés dans la <a href="<?=$chemin?>pages/doc/raccourcis">référence des liens courts</a><br>
          <input type="checkbox"> Vérifier que les nouveaux tags CSS soient bien rentrés dans la <a href="<?=$chemin?>pages/dev/reference">référence du CSS</a><br>
          <input type="checkbox"> Vérifier que les nouvelles fonctions soient bien rentrées dans la <a href="<?=$chemin?>pages/dev/fonctions">référence des fonctions</a>
        </p>

        <br>
        <br>

        <h4>Faire une mise à jour:</h4>

        <p>
          <input type="checkbox"> Commit les changements et vérifier que le commit ait bien été push dans <a href="https://bitbucket.org/EricBisceglia/nobleme.com/commits/all">le dépôt public</a><br>
          <input type="checkbox"> Commencer par faire un backup complet du www et du sql du site en production<br>
          <input type="checkbox"> Avant de faire la mise à jour en production, <a href="<?=$chemin?>pages/dev/fermeture">fermer le site au public</a> si nécessaire<br>
          <input type="checkbox"> Aller sur la version en production du site et <a href="<?=$chemin?>pages/dev/sql">faire les requêtes SQL</a> s'il y en a<br>
          <input type="checkbox"> Mettre en ligne les fichiers modifiés dans le commit de la mise à jour<br>
          <input type="checkbox"> Mettre à jour le <a href="<?=$chemin?>pages/todo/roadmap">plan de route</a> et la <a href="<?=$chemin?>pages/todo/index">liste des tâches</a><br>
          <input type="checkbox"> Nouvelle version du site ? Si oui, <a href="<?=$chemin?>pages/dev/version">changer le numéro de version</a><br>
          <input type="checkbox"> S'il s'agit d'une nouvelle version, mettre un tag dans le dépôt avec le nom de la version<br>
          <input type="checkbox"> Vérifier que la mise à jour se soit bien passé et que tout fonctionne comme prévu<br>
          <input type="checkbox"> Il ne reste maintenant plus qu'à <a href="<?=$chemin?>pages/dev/fermeture">rouvrir le site au public</a> s'il était fermé
        </p>

        <br>
        <br>

        <h4>Après une mise à jour:</h4>

        <p>
          <input type="checkbox"> Choper l'url du dernier commit dans <a href="https://bitbucket.org/EricBisceglia/nobleme.com/commits/all">le dépôt public</a> et le partager publiquement sur #dev via <a href="<?=$chemin?>pages/dev/ircbot">le bot IRC</a><br>
          <input type="checkbox"> Archiver les backups du www et du sql et en faire une copie de sauvegarde sur HDD externe<br>
          <input type="checkbox"> Supprimer les requêtes qui ne sont plus nécessaires dans la source de /pages/dev/maj.php<br>
          <input type="checkbox"> Félicitations, la mise à jour est finie et tout s'est bien passé <?=bbcode(":)")?>
        </p>

      </div>



<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';