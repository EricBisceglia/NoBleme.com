<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/dev.act.php';         # Actions
include_once './../../lang/dev/devtools.lang.php';  # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_administrators();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Delete the version
$version_number = dev_versions_delete(form_fetch_element('version_id', 0));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

if($version_number) { ?>

<td class="red text_white bold" colspan="4">
  <?=__('dev_versions_table_deleted', 0, 0, 0, array($version_number))?>
</td>

<?php } else { ?>

<td class="orange text_white bold" colspan="4">
  <?=__('dev_versions_table_not_existing')?>
</td>

<?php } ?>