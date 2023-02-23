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

$api_doc_menu['intro']  = isset($api_doc_menu['intro'])   ? ' selected' : '';
$api_doc_menu['quotes'] = isset($api_doc_menu['quotes'])  ? ' selected' : '';
$api_doc_menu['users']  = isset($api_doc_menu['users'])   ? ' selected' : '';


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Display the menu                                                                                                  ?>

<div class="padding_bot align_center api_doc_menu">
  <fieldset>
    <h5>
      <?=__('api_intro_title').__(':')?>
      <select class="inh" id="api_doc_menu" name="api_doc_menu" onchange="api_doc_menu();">
        <option value="intro"<?=$api_doc_menu['intro']?>>
          <?=__('api_intro_menu')?>
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