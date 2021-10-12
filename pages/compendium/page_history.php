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
// Edit a compendium page history entry

// Edit a page history entry if requested
if(isset($_POST['compendium_page_history_edit']))
{
  // Only administrators can edit history entries
  user_restrict_to_administrators();

  // Fetch the history entry's id and new values
  $compendium_history_id    = (int)form_fetch_element('compendium_page_history_edit');
  $compendium_history_data  = array(  'body_en' => form_fetch_element('compendium_page_history_edit_summary_en')  ,
                                      'body_fr' => form_fetch_element('compendium_page_history_edit_summary_fr')  ,
                                      'major'   => form_fetch_element('compendium_page_history_edit_major')       );

  // Edit the history entry
  compendium_page_history_edit( $compendium_history_id    ,
                                $compendium_history_data  );
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete a compendium page history entry

// Delete a page history entry if requested
if(isset($_POST['compendium_page_history_delete']))
{
  // Only administrators can edit history entries
  user_restrict_to_administrators();

  // Fetch the history entry's id
  $compendium_history_id = (int)form_fetch_element('compendium_page_history_delete');

  // Delete the history entry
  compendium_page_history_delete( $compendium_history_id );
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch compendium page history

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
      <?php if($is_admin && $compendium_page_history['rows'] > 1) { ?>
      <th>
        <?=__('act')?>
      </th>
      <?php } ?>
    </tr>

  </thead>
  <tbody class="altc align_center">

    <?php for($i = 0; $i < $compendium_page_history['rows']; $i++) { ?>

    <tr<?=$compendium_page_history[$i]['css']?>>

      <td class="spaced nowrap">
        <?=$compendium_page_history[$i]['date']?>
      </td>

      <td class="spaced">
        <?php if(($i + 1) == $compendium_page_history['rows']) { ?>
        <?=__('compendium_page_history_creation')?>
        <?php } else { ?>
        <?=$compendium_page_history[$i]['body']?>
        <?php } ?>
      </td>

      <?php if($is_admin && $compendium_page_history['rows'] > 1) { ?>
      <td class="spaced nowrap">
        <?php if(($i + 1) == $compendium_page_history['rows']) { ?>
        &nbsp;
        <?php } else { ?>
        <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: 'M', title: __('edit'), title_case: 'initials', onclick: "compendium_page_history_edit_form('".$compendium_page_history[$i]['id']."');")?>
        <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "compendium_page_history_delete('".$compendium_page_id."', '".$compendium_page_history[$i]['id']."', '".__('compendium_page_history_delete')."');")?>
        <?php } ?>
      </td>
      <?php } ?>

    </tr>

    <?php } ?>

  </tbody>
</table>