<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../inc/bbcodes.inc.php';         # BBCodes

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/image_admin";
$page_title_en    = "Compendium images";
$page_title_fr    = "Compendium : images";

// Compendium admin menu selection
$compendium_admin_menu['images'] = 1;

// Extra CSS & JS
$css  = array('compendium');
$js   = array('common/toggle', 'compendium/list', 'compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Upload a new image

if(isset($_POST['compendium_image_upload_submit']))
{
  // Fetch the image file data
  $compendium_image_upload_file = form_fetch_element('compendium_image_upload_file', request_type: 'FILES');

  // Fetch the elements
  $compendium_image_upload_name       = form_fetch_element('compendium_image_upload_name');
  $compendium_image_upload_tags       = form_fetch_element('compendium_image_upload_tags');
  $compendium_image_upload_caption_en = form_fetch_element('compendium_image_upload_caption_en');
  $compendium_image_upload_caption_fr = form_fetch_element('compendium_image_upload_caption_fr');
  $compendium_image_upload_nsfw       = form_fetch_element('compendium_image_upload_nsfw', element_exists: true);
  $compendium_image_upload_gross      = form_fetch_element('compendium_image_upload_gross', element_exists: true);
  $compendium_image_upload_offensive  = form_fetch_element('compendium_image_upload_offensive', element_exists: true);

  // Assemble the image data
  $compendium_image_upload_data = array(  'name'        => $compendium_image_upload_name        ,
                                          'tags'        => $compendium_image_upload_tags        ,
                                          'caption_en'  => $compendium_image_upload_caption_en  ,
                                          'caption_fr'  => $compendium_image_upload_caption_fr  ,
                                          'nsfw'        => $compendium_image_upload_nsfw        ,
                                          'gross'       => $compendium_image_upload_gross       ,
                                          'offensive'   => $compendium_image_upload_offensive   );

  // Attempt to upload the image
  $compendium_image_upload = compendium_images_upload(  $compendium_image_upload_file ,
                                                        $compendium_image_upload_data );
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete or restore an image

if(isset($_POST['compendium_images_search_action']))
  compendium_images_delete( form_fetch_element('compendium_images_search_action_id')  ,
                            form_fetch_element('compendium_images_search_action')     );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recalculate compendium image links

if(isset($_POST['compendium_images_recalculate_links']))
  compendium_images_recalculate_all_links();



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the compendium images

// Fetch the sorting order
$compendium_images_sort_order = form_fetch_element('compendium_images_search_order', 'date');

// Assemble the search query
$compendium_images_list_search = array( 'name'    => form_fetch_element('compendium_images_search_name')    ,
                                        'date'    => form_fetch_element('compendium_images_search_date')    ,
                                        'nsfw'    => form_fetch_element('compendium_images_search_nsfw')    ,
                                        'used_en' => form_fetch_element('compendium_images_search_used_en') ,
                                        'used_fr' => form_fetch_element('compendium_images_search_used_fr') ,
                                        'tags'    => form_fetch_element('compendium_images_search_tags')    ,
                                        'caption' => form_fetch_element('compendium_images_search_caption') ,
                                        'deleted' => form_fetch_element('compendium_images_search_deleted') ,);

// Fetch the images
$compendium_images_list = compendium_images_list( sort_by:  $compendium_images_sort_order   ,
                                                  search:   $compendium_images_list_search  );

// Fetch the appearance, peak, and image upload years
$compendium_image_list_years = compendium_images_list_years();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_40 smallpadding_bot">

  <form method="POST" enctype="multipart/form-data" action="image_admin">
    <fieldset>

      <h5 class="align_center padding_top padding_bot">
        <?=__('compendium_image_upload_label')?>
      </h5>

      <div class="tinyadding_top smallpadding_bot">
        <input type="file" class="indiv align_center" name="compendium_image_upload_file" id="compendium_image_upload_file" onchange="compendium_image_list_upload();">
      </div>

      <div class="hidden" id="compendium_image_upload_form">

        <div class="smallpadding_bot">
          <label for="compendium_image_upload_name"><?=__('compendium_image_upload_name')?></label>
          <input type="text" class="indiv" id="compendium_image_upload_name" name="compendium_image_upload_name" value="" autocomplete="off" list="compendium_image_name_list" onkeyup="compendium_autocomplete_image('compendium_image_upload_name', 'compendium_image_name_list_parent', 'compendium_image_name_list');">
        </div>
        <div id="compendium_image_name_list_parent">
          <datalist id="compendium_image_name_list">
            <option value=" ">&nbsp;</option>
          </datalist>
        </div>

        <div class="smallpadding_bot">
          <label for="compendium_image_upload_tags"><?=__('compendium_image_upload_tags')?></label>
          <input type="text" class="indiv" id="compendium_image_upload_tags" name="compendium_image_upload_tags" value="">
        </div>

        <div class="flexcontainer smallpadding_bot">
          <div class="flex spaced_right">

            <label for="compendium_image_upload_caption_en"><?=__('compendium_image_upload_caption_en')?></label>
            <textarea id="compendium_image_upload_caption_en" class="compendium_admin_summary" name="compendium_image_upload_caption_en"></textarea>

          </div>
          <div class="flex spaced_left">

            <label for="compendium_image_upload_caption_fr"><?=__('compendium_image_upload_caption_fr')?></label>
            <textarea id="compendium_image_upload_caption_fr" class="compendium_admin_summary" name="compendium_image_upload_caption_fr"></textarea>

          </div>
        </div>

        <input type="checkbox" id="compendium_image_upload_nsfw" name="compendium_image_upload_nsfw">
        <label class="label_inline" for="compendium_image_upload_nsfw"><?=__('compendium_image_upload_nsfw')?></label><br>

        <input type="checkbox" id="compendium_image_upload_gross" name="compendium_image_upload_gross">
        <label class="label_inline" for="compendium_image_upload_gross"><?=__('compendium_image_upload_gross')?></label><br>

        <input type="checkbox" id="compendium_image_upload_offensive" name="compendium_image_upload_offensive">
        <label class="label_inline" for="compendium_image_upload_offensive"><?=__('compendium_image_upload_offensive')?></label>

        <div class="smallpadding_top padding_bot">
          <input type="submit" id="compendium_image_upload_submit" name="compendium_image_upload_submit" value="<?=__('compendium_image_upload_submit')?>">
        </div>

      </div>

      <?php if(isset($compendium_image_upload) && $compendium_image_upload) { ?>
      <div class="smallpadding_top padding_bot" id="compendium_image_upload_error">
        <?php if(!is_int($compendium_image_upload)) { ?>
        <div class="red text_white spaced uppercase big bold">
          <?=__('error').__(':', spaces_after: 1).$compendium_image_upload?>
        </div>
        <?php } else { ?>
        <div class="green text_white spaced uppercase big bold">
          <?=__('compendium_image_upload_ok')?>
        </div>
        <?php } ?>
      </div>
      <?php } ?>

    </fieldset>
  </form>

</div>

<hr>

<div class="width_80">

  <h2 class="padding_top bigpadding_bot align_center">
    <?=__('compendium_image_list_title')?>
    <?=__icon('refresh', alt: 'R', title: __('compendium_image_list_refresh'), class: 'valign_middle pointer spaced_left', onclick: "compendium_recalculate_image_links('".__('compendium_image_list_warning')."');")?>
  </h2>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_image_list_copy')?>
        </th>
        <th>
          <?=__('compendium_image_list_name')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_image_list_search('name');")?>
        </th>
        <th>
          <?=__('compendium_image_list_tags')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_image_list_search('tags');")?>
        </th>
        <th>
          <?=__('compendium_image_list_used_en')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_image_list_search('used_en');")?>
        </th>
        <th>
          <?=__('compendium_image_list_used_fr')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_image_list_search('used_fr');")?>
        </th>
        <th>
          <?=__('compendium_image_list_uploaded')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_image_list_search('date');")?>
        </th>
        <th>
          <?=__('compendium_image_list_caption')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_image_list_search('caption');")?>
        </th>
        <th>
          <?=__('compendium_list_admin_nsfw')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_image_list_search('nsfw');")?>
        </th>
        <th>
          <?=__('compendium_list_admin_wip')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_image_list_search('deleted');")?>
        </th>
        <th>
          <?=__('act')?>
        </th>
      </tr>

      <tr>

        <th>
          &nbsp;
        </th>

        <th>
          <input type="hidden" name="compendium_images_search_order" id="compendium_images_search_order" value="<?=$compendium_images_sort_order?>">
          <input type="text" class="table_search" name="compendium_images_search_name" id="compendium_images_search_name" value="" onkeyup="compendium_image_list_search();">
        </th>

        <th>
          <input type="text" class="table_search" name="compendium_images_search_tags" id="compendium_images_search_tags" value="" onkeyup="compendium_image_list_search();">
        </th>

        <th>
          <input type="text" class="table_search" name="compendium_images_search_used_en" id="compendium_images_search_used_en" value="" onkeyup="compendium_image_list_search();">
        </th>

        <th>
          <input type="text" class="table_search" name="compendium_images_search_used_fr" id="compendium_images_search_used_fr" value="" onkeyup="compendium_image_list_search();">
        </th>

        <th>
          <select class="table_search" name="compendium_images_search_date" id="compendium_images_search_date" onchange="compendium_image_list_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = 0; $i < $compendium_image_list_years['rows']; $i++) { ?>
            <option value="<?=$compendium_image_list_years[$i]['year']?>"><?=$compendium_image_list_years[$i]['year']?></option>
            <?php } ?>
          </select>
        </th>

        <th class="compendium_admin_search_small">
          <select class="table_search" name="compendium_images_search_caption" id="compendium_images_search_caption" onchange="compendium_image_list_search();">
            <option value="">&nbsp;</option>
            <option value="none"><?=string_change_case(__('none'), 'initials')?></option>
            <option value="monolingual"><?=__('compendium_list_admin_monolingual')?></option>
            <option value="bilingual"><?=__('compendium_list_admin_bilingual')?></option>
            <option value="french"><?=string_change_case(__('french'), 'initials')?></option>
            <option value="english"><?=string_change_case(__('english'), 'initials')?></option>
          </select>
        </th>

        <th class="compendium_admin_search_small">
          <select class="table_search" name="compendium_images_search_nsfw" id="compendium_images_search_nsfw" onchange="compendium_image_list_search();">
            <option value="">&nbsp;</option>
            <option value="safe"><?=__('compendium_list_admin_safe')?></option>
            <option value="nsfw"><?=__('compendium_list_admin_unsafe')?></option>
            <option value="image"><?=__('compendium_image_list_nsfw')?></option>
            <option value="gross"><?=__('compendium_list_admin_gross')?></option>
            <option value="offensive"><?=__('compendium_list_admin_offensive')?></option>
          </select>
        </th>

        <th class="compendium_admin_search_small">
          <select class="table_search" name="compendium_images_search_deleted" id="compendium_images_search_deleted" onchange="compendium_image_list_search();">
            <option value="0">&nbsp;</option>
            <option value="1"><?=__('compendium_image_list_notdeleted')?></option>
            <option value="2"><?=__('compendium_list_admin_deleted')?></option>
          </select>
        </th>

        <th>
          &nbsp;
        </th>

      </tr>

    </thead>

    <tbody class="altc2 nowrap" id="compendium_image_list_tbody">

      <?php } ?>

      <tr>
        <td colspan="10" class="uppercase text_light dark bold align_center">
          <?=__('compendium_image_list_count', preset_values: array($compendium_images_list['rows']))?>
        </td>
      </tr>

      <?php for($i = 0; $i < $compendium_images_list['rows']; $i++) { ?>

      <tr id="compendium_image_admin_row_<?=$compendium_images_list[$i]['id']?>">

        <td class="align_center nowrap">
          <?=__icon('copy', is_small: true, class: 'valign_middle pointer spaced_right', alt: 'C', title: __('copy'), title_case: 'initials', onclick: "compendium_image_list_clipboard('".$compendium_images_list[$i]['fullname']."', ".$compendium_images_list[$i]['blur'].");")?>
          <?=__icon('image', is_small: true, class: 'valign_middle pointer', alt: 'P', title: __('image'), title_case: 'initials', onclick: "compendium_image_list_clipboard('".$compendium_images_list[$i]['fullname']."', ".$compendium_images_list[$i]['blur'].", 1);")?>
        </td>

        <td class="align_left tooltip_container"  id="compendium_image_list_preview_cell_<?=$compendium_images_list[$i]['id']?>" onmouseover="compendium_image_list_preview('<?=$compendium_images_list[$i]['id']?>', '<?=$compendium_images_list[$i]['fullname']?>', '<?=$path?>');">
          <?=__link('pages/compendium/image?name='.$compendium_images_list[$i]['fullname'], $compendium_images_list[$i]['name'])?>
          <div class="tooltip compendium_image_preview">
            <h2 class="align_center padding_bot">
              <?=$compendium_images_list[$i]['fullname']?>
            </h2>
            <div class="padding_top padding_bot align_center" id="compendium_image_list_container_<?=$compendium_images_list[$i]['id']?>">
              &nbsp;
            </div>
            <?php if($compendium_images_list[$i]['body']) { ?>
            <div class="padding_top padding_bot align_center">
              <?=$compendium_images_list[$i]['body']?>
            </div>
            <?php } ?>
          </div>
        </td>

        <?php if($compendium_images_list[$i]['tags']) { ?>
        <td class="align_center tooltip_container">
          <?=$compendium_images_list[$i]['tags']?>
          <div class="tooltip">
            <?=$compendium_images_list[$i]['tags_full']?>
          </div>
        </td>
        <?php } else { ?>
        <td class="align_center">
          &nbsp;
        </td>
        <?php } ?>

        <?php if($compendium_images_list[$i]['used_en']) { ?>
        <td class="align_center tooltip_container">
          <?=$compendium_images_list[$i]['used_en']?>
          <div class="tooltip">
            <?=$compendium_images_list[$i]['used_en_f']?>
          </div>
        </td>
        <?php } else { ?>
        <td class="align_center">
          &nbsp;
        </td>
        <?php } ?>

        <?php if($compendium_images_list[$i]['used_fr']) { ?>
        <td class="align_center tooltip_container">
          <?=$compendium_images_list[$i]['used_fr']?>
          <div class="tooltip">
            <?=$compendium_images_list[$i]['used_fr_f']?>
          </div>
        </td>
        <?php } else { ?>
        <td class="align_center">
          &nbsp;
        </td>
        <?php } ?>

        <td class="align_center">
          <?=$compendium_images_list[$i]['date']?>
        </td>

        <td class="align_center">
          <?php if($compendium_images_list[$i]['caption_en']) { ?>
          <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle" height="14" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
          <?php } if($compendium_images_list[$i]['caption_fr']) { ?>
          <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle" height="14" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
          <?php } ?>
        </td>

        <?php if($compendium_images_list[$i]['blur']) { ?>
        <td class="align_center tooltip_container">
          <?=__icon('warning', is_small: true, class: 'valign_middle pointer', alt: 'X', title: __('compendium_list_admin_nsfw'), title_case: 'initials')?>
          <div class="tooltip">
            <?php if($compendium_images_list[$i]['nsfw']) { ?>
            <?=__('compendium_image_list_nsfw')?><br>
            <?php } if($compendium_images_list[$i]['gross']) { ?>
            <?=__('compendium_list_admin_gross')?><br>
            <?php } if($compendium_images_list[$i]['offensive']) { ?>
            <?=__('compendium_list_admin_offensive')?>
            <?php } ?>
          </div>
        </td>
        <?php } else { ?>
        <td>
          &nbsp;
        </td>
        <?php } ?>

        <td class="align_center">
          <?php if($compendium_images_list[$i]['deleted']) { ?>
          <?=__icon('refresh', is_small: true, alt: 'R', title: __('restore'), title_case: 'initials', onclick: "compendium_image_list_search(null, 'restore', '".$compendium_images_list[$i]['id']."', '".__('compendium_image_list_restore')."');")?>
          <?php } else { ?>
          &nbsp;
          <?php } ?>
        </td>

        <td class="align_center nowrap">
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced_right', alt: 'M', title: __('edit'), title_case: 'initials', href: 'pages/compendium/image_edit?id='.$compendium_images_list[$i]['id'])?>
          <?php if($compendium_images_list[$i]['used_en'] || $compendium_images_list[$i]['used_fr']) { ?>
          <?=__icon('x', is_small: true, alt: 'X', title: __('compendium_image_list_no_delete'), onclick: "alert('".__('compendium_image_list_no_delete')."')")?>
          <?php } else if(!$compendium_images_list[$i]['deleted']) { ?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "compendium_image_list_search(null, 'delete', '".$compendium_images_list[$i]['id']."', '".__('compendium_image_list_delete')."');")?>
          <?php } else { ?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "compendium_image_list_search(null, 'hard_delete', '".$compendium_images_list[$i]['id']."', '".__('compendium_image_list_hard')."');")?>
          <?php } ?>
        </td>

      </tr>

      <?php } ?>

      <?php if(!page_is_fetched_dynamically()) { ?>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }