<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './inc/includes.inc.php';        # Core
include_once './lang/users/banned.lang.php';  # Translations

// Limit page access rights
user_restrict_to_ip_banned($path);

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "banned_ip";
$page_title_en    = "IP banned!";
$page_title_fr    = "IP bannie !";
$page_description = "Bad news: you have been IP banned from NoBleme.";

// Hide the header and the footer
$hide_header = 1;
$hide_footer = 1;

// Extra CSS
$css = array('index');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /*********************************************/ include './inc/header.inc.php'; ?>

<div class="width_60">

  <div class="align_center hugepadding_top bigpadding_bot bigglow nobleme_logo">
    <img src="<?=$path?>img/common/logo_full.png" alt="NoBleme.com">
  </div>

  <div class="flexcontainer">
    <div class="dev_div_border" style="flex:3">

      <h1 class="bigglow bigpadding_top smallpadding_bot align_center">
        Bad news…
      </h1>

      <p>
        Your current IP address has been banned from accessing this website.
      </p>

      <p>
        This type of extreme punishment is only given in special cases where we have no other choice left. If you are the author of the mischief that caused you to be IP banned, then you know exactly why you are reading this. If not, then we are deeply sorry that you have been banned as collateral damage, but we have no other choice than to restrict your access to the website as your <?=__link('https://en.wikipedia.org/wiki/IP_address', 'IP address', "bold", 0)?> is shared with someone else who has been using the website in abusive ways.
      </p>

      <p>
        Once this IP ban expires, we hope to see you again under different circumstances.
      </p>

    </div>
    <div style="flex:1">
      &nbsp;
    </div>
    <div class="dev_div_border" style="flex:3">

      <h1 class="bigglow bigpadding_top smallpadding_bot align_center">
        Désolé…
      </h1>

      <p>
        Votre adresse IP actuelle est bloquée sur tout le site.
      </p>

      <p>
        Ce type de punition extrême n'est utilisé que dans des cas spéciaux où nous n'avons pas d'autre option qu'une exclusion totale. Si vous êtes responsable du chaos qui a mené à ce bannissement, vous savez exactement pourquoi vous voyez ce message. Si ce n'est pas le cas, nous sommes désolés de vous annoncer que vous êtes victime de dommages collatéraux : quelqu'un d'autre partageant la même <?=__link('https://fr.wikipedia.org/wiki/Adresse_IP', 'adresse IP', "bold", 0)?> que vous a causé tant de problèmes que nous n'avons pas eu d'autre option que de bannir cette adresse IP.
      </p>

      <p>
        Une fois ce bannissement fini, nous espérons vous revoir dans de meilleures circonstances.
      </p>

    </div>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/***********************************************************************************/ include './inc/footer.inc.php'; }