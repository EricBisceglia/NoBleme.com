<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/functions_time.inc.php';  # Time manangement

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Compendium page history

// Fetch the compendium page's id
$compendium_page_id = (int)form_fetch_element('compendium_page_id');

// Stop here if there is no compendium page id
if(!$compendium_page_id)
  exit(string_change_case(__('error'), 'uppercase').__(':').__('compendium_page_history_error', spaces_before: 1));

// Fetch the compendium page's history
$compendium_page_history = compendium_page_history_list($compendium_page_id);

// Stop here if there is no compendium page history
if(!$compendium_page_history)
  exit(string_change_case(__('error'), 'uppercase').__(':').__('compendium_page_history_error', spaces_before: 1));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<h4 class="padding_bot align_center">
  <?=__('compendium_page_history_title')?>
</h4>

<table>
  <thead>

    <tr class="uppercase">
      <th>
        <?=__('date')?>
      </th>
      <th>
        <?=__('description')?>
      </th>
    </tr>

  </thead>
  <tbody class="altc align_center">

    <?php for($i = 0; $i < $compendium_page_history['rows']; $i++) { ?>
    <tr>
      <td class="nowrap">
        <?=$compendium_page_history[$i]['date']?>
      </td>
      <td>
        <?php if(($i + 1) == $compendium_page_history['rows']) { ?>
        <?=__('compendium_page_history_creation')?>
        <?php } else { ?>
        <?=$compendium_page_history[$i]['body']?>
        <?php } ?>
      </td>
    </tr>
    <?php } ?>

  </tbody>
</table>