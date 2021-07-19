<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/dev.act.php';         # Actions
include_once './../../lang/dev.lang.php';           # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/blog_edit";
$page_title_en    = "Edit devblog";
$page_title_fr    = "Modifier un devblog";
$page_description = "Edit an existing devblog, documenting NoBleme's development history.";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit devblog

// Fetch the blog's id
$blog_id = (int)form_fetch_element('id', request_type: 'GET');

// Redirect if no ID is provided
if(!$blog_id)
  exit(header("Location: ".$path."pages/dev/blog_list"));

// Fetch the devblog's contents
$devblog_data = dev_blogs_get($blog_id);

// Redirect if the devblog does not exist
if(!isset($devblog_data))
  exit(header("Location: ".$path."pages/dev/blog_list"));

// Fetch the postdata
$devblog_title_en = form_fetch_element('devblog_edit_title_en');
$devblog_title_fr = form_fetch_element('devblog_edit_title_fr');
$devblog_body_en  = form_fetch_element('devblog_edit_body_en');
$devblog_body_fr  = form_fetch_element('devblog_edit_body_fr');

// Prepare the form values
$devblog_edit_title_en  = (isset($_POST['devblog_edit_title_en']))  ? $devblog_title_en : $devblog_data['title_en'];
$devblog_edit_title_fr  = (isset($_POST['devblog_edit_title_fr']))  ? $devblog_title_fr : $devblog_data['title_fr'];
$devblog_edit_body_en   = (isset($_POST['devblog_edit_body_en']))   ? $devblog_body_en  : $devblog_data['body_en'];
$devblog_edit_body_fr   = (isset($_POST['devblog_edit_body_fr']))   ? $devblog_body_fr  : $devblog_data['body_fr'];

// Prepare current date values for the preview form
$devblog_date   = date_to_text(time(), strip_day: 1);
$devblog_since  = time_since(time());

// Publish the devblog
if(isset($_POST['devblog_edit_submit']))
{
  // Prepare an array with the contents
  $devblog_contents = array(  'title_en'  => $devblog_title_en  ,
                              'title_fr'  => $devblog_title_fr  ,
                              'body_en'   => $devblog_body_en   ,
                              'body_fr'   => $devblog_body_fr   );

  // Attempt to edit the devblog
  $devblog_edit = dev_blogs_edit( $blog_id          ,
                                  $devblog_contents );

  // Redirect to the edited devblog if all went well
  if(!isset($devblog_edit))
    exit(header("Location: ".$path."pages/dev/blog?id=".$blog_id));
}





/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__link('pages/dev/blog_list', __('dev_blog_title'), 'noglow')?>
  </h1>

  <h5 class="padding_bot">
    <?=__('dev_blog_add_subtitle')?>
  </h5>

  <form method="POST">
    <fieldset>

      <div class="flexcontainer smallpadding_top smallpadding_bot">

        <div class="flex spaced">

          <label for="devblog_edit_title_en"><?=__('dev_blog_add_title_en')?></label>
          <input class="indiv" type="text" id="devblog_edit_title_en" name="devblog_edit_title_en" value="<?=$devblog_edit_title_en?>">

          <div class="smallpadding_top">
            <label for="devblog_edit_body_en"><?=__('dev_blog_add_body_en')?></label>
            <textarea id="devblog_edit_body_en" name="devblog_edit_body_en"><?=$devblog_edit_body_en?></textarea>
          </div>

        </div>
        <div class="flex spaced">

          <label for="devblog_edit_title_fr"><?=__('dev_blog_add_title_fr')?></label>
          <input class="indiv" type="text" id="devblog_edit_title_fr" name="devblog_edit_title_fr" value="<?=$devblog_edit_title_fr?>">

          <div class="smallpadding_top">
            <label for="devblog_edit_body_fr"><?=__('dev_blog_add_body_fr')?></label>
            <textarea id="devblog_edit_body_fr" name="devblog_edit_body_fr"><?=$devblog_edit_body_fr?></textarea>
          </div>

        </div>

      </div>

      <?php if(isset($devblog_edit)) { ?>

      <div class="smallpadding_bot">
        <h5 class="align_center uppercase bold red text_white">
          <?=$devblog_edit?>
        </h5>
      </div>

      <?php } ?>

      <span class="spaced_right">
        <input type="submit" name="devblog_edit_preview" value="<?=string_change_case(__('preview'), 'initials')?>">
      </span>
      <input type="submit" name="devblog_edit_submit" value="<?=__('dev_blog_edit_submit')?>">

    </fieldset>
  </form>

  <?php if(isset($_POST['devblog_edit_preview'])) { ?>

  <?php if($devblog_title_en) { ?>

  <div class="padding_top">

    <hr>

    <h1>
      <?=__('dev_blog_title')?>
    </h1>

    <h5>
      <?=$devblog_title_en?>
    </h5>

    <span class="monospace"><?=__('dev_blog_published', preset_values: array($devblog_date, $devblog_since))?></span>

    <div class="align_justify padding_top hugepadding_bot">
      <?=$devblog_body_en?>
    </div>

  </div>

  <?php } if($devblog_title_fr) { ?>

  <div class="padding_top">

    <hr>

    <h1>
      <?=__('dev_blog_title')?>
    </h1>

    <h5>
      <?=$devblog_title_fr?>
    </h5>

    <span class="monospace"><?=__('dev_blog_published', preset_values: array($devblog_date, $devblog_since))?></span>

    <div class="align_justify padding_top hugepadding_bot">
      <?=$devblog_body_fr?>
    </div>

  </div>

  <?php } ?>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }