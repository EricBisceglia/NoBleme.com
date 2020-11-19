<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';                  # Core
include_once './../../inc/functions_time.inc.php';            # Time management
include_once './../../actions/users/user.act.php';            # Admin list
include_once './../../actions/admin/user_management.act.php'; # Actions
include_once './../../lang/admin/user_management.lang.php';   # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/user_rights";
$page_title_en    = "User rights";
$page_title_fr    = "Permissions";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Administrative team list

$admin_list = user_list_admins('activity');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center bigpadding_bot">
    <?=__('admin_rights_title')?>
  </h1>

</div>

<div class="width_30">

  <table>
    <thead class="uppercase">

      <tr>
        <th>
          <?=__('username')?>
        </th>
        <th>
          <?=__('rights')?>
        </th>
        <th>
          <?=__('activity')?>
        </th>
      </tr>

    </thead>
    <tbody class="align_center">

      <?php for($i = 0; $i < $admin_list['rows'] ; $i++) { ?>

      <tr>
        <td>
          <?=__link('todo_link?id='.$admin_list[$i]['id'], $admin_list[$i]['username'], $admin_list[$i]['css'])?>
        </td>
        <td class="<?=$admin_list[$i]['css']?>">
          <?=$admin_list[$i]['title']?>
        </td>
        <td>
          <?=$admin_list[$i]['activity']?>
        </td>
      </tr>

      <?php } ?>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }