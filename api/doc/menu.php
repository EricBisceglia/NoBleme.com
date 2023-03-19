<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }

/*********************************************************************************************************************/
/*                                                                                                                   */
/*                        Include this page to display the API documentation's dropdown menu.                        */
/*                                                                                                                   */
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare the menu entries

$api_doc_menu['intro']      = isset($api_doc_menu['intro'])       ? ' selected' : '';
$api_doc_menu['changelog']  = isset($api_doc_menu['changelog'])   ? ' selected' : '';
$api_doc_menu['compendium'] = isset($api_doc_menu['compendium'])  ? ' selected' : '';
$api_doc_menu['dev']        = isset($api_doc_menu['dev'])         ? ' selected' : '';
$api_doc_menu['irc']        = isset($api_doc_menu['irc'])         ? ' selected' : '';
$api_doc_menu['meetups']    = isset($api_doc_menu['meetups'])     ? ' selected' : '';
$api_doc_menu['quotes']     = isset($api_doc_menu['quotes'])      ? ' selected' : '';
$api_doc_menu['users']      = isset($api_doc_menu['users'])       ? ' selected' : '';


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Display the menu                                                                                                  ?>

<div class="padding_bot align_center api_doc_menu">
  <fieldset>
    <h5>
      <?=__('submenu_nobleme_api').__(':')?>
      <select class="inh" id="api_doc_menu" name="api_doc_menu" onchange="api_doc_menu();">
        <option value="intro"<?=$api_doc_menu['intro']?>>
          <?=__('api_intro_menu')?>
        </option>
        <option value="changelog"<?=$api_doc_menu['changelog']?>>
          <?=__('api_changelog_menu')?>
        </option>
        <option value="compendium"<?=$api_doc_menu['compendium']?>>
          <?=__('api_compendium_menu')?>
        </option>
        <option value="dev"<?=$api_doc_menu['dev']?>>
          <?=__('api_dev_menu')?>
        </option>
        <option value="irc"<?=$api_doc_menu['irc']?>>
          <?=__('api_irc_menu')?>
        </option>
        <option value="meetups"<?=$api_doc_menu['meetups']?>>
          <?=__('api_meetups_menu')?>
        </option>
        <option value="quotes"<?=$api_doc_menu['quotes']?>>
          <?=__('api_quotes_menu')?>
        </option>
        <option value="users"<?=$api_doc_menu['users']?>>
          <?=__('api_users_menu')?>
        </option>
      </select>
    </h5>
  </fieldset>
</div>

<hr>