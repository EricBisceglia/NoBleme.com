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
user_restrict_to_maintainer();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/blog_add";
$page_title_en    = "New devblog";
$page_title_fr    = "Nouveau devblog";
$page_description = "Create a new devblog, documenting NoBleme's development history.";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Publish devblog

// Fetch the postdata
$devblog_title_en = form_fetch_element('devblog_add_title_en');
$devblog_title_fr = form_fetch_element('devblog_add_title_fr');
$devblog_body_en  = form_fetch_element('devblog_add_body_en');
$devblog_body_fr  = form_fetch_element('devblog_add_body_fr');

// Prepare current date values for the preview form
$devblog_date   = date_to_text(time(), strip_day: 1);
$devblog_since  = time_since(time());

// Publish the devblog
if(isset($_POST['devblog_add_submit']))
{
  // Prepare an array with the contents
  $devblog_contents = array(  'title_en'  => $devblog_title_en  ,
                              'title_fr'  => $devblog_title_fr  ,
                              'body_en'   => $devblog_body_en   ,
                              'body_fr'   => $devblog_body_fr   );
  // Attempt to create the devblog
  $devblog_create = dev_blogs_add($devblog_contents);

  // Redirect to the newly created devblog if all went well
  if(is_int($devblog_create))
    exit(header("Location: ".$path."pages/dev/blog?id=".$devblog_create));
}





/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__link('pages/dev/blog_list', __('dev_blog_title'), 'text_red noglow')?>
  </h1>

  <h5 class="padding_bot">
    <?=__('dev_blog_add_subtitle')?>
  </h5>

  <form method="POST">
    <fieldset>

      <div class="flexcontainer smallpadding_top smallpadding_bot">

        <div class="flex spaced">

          <label for="devblog_add_title_en"><?=__('dev_blog_add_title_en')?></label>
          <input class="indiv" type="text" id="devblog_add_title_en" name="devblog_add_title_en" value="<?=$devblog_title_en?>">

          <div class="smallpadding_top">
            <label for="devblog_add_body_en"><?=__('dev_blog_add_body_en')?></label>
            <textarea id="devblog_add_body_en" name="devblog_add_body_en"><?=$devblog_body_en?></textarea>
          </div>

        </div>
        <div class="flex spaced">

          <label for="devblog_add_title_fr"><?=__('dev_blog_add_title_fr')?></label>
          <input class="indiv" type="text" id="devblog_add_title_fr" name="devblog_add_title_fr" value="<?=$devblog_title_fr?>">

          <div class="smallpadding_top">
            <label for="devblog_add_body_fr"><?=__('dev_blog_add_body_fr')?></label>
            <textarea id="devblog_add_body_fr" name="devblog_add_body_fr"><?=$devblog_body_fr?></textarea>
          </div>

        </div>

      </div>

      <?php if(isset($devblog_create)) { ?>

      <div class="smallpadding_bot">
        <h5 class="align_center uppercase bold red text_white">
          <?=$devblog_create?>
        </h5>
      </div>

      <?php } ?>

      <span class="spaced_right">
        <input type="submit" name="devblog_add_preview" value="<?=string_change_case(__('preview'), 'initials')?>">
      </span>
      <input type="submit" name="devblog_add_submit" value="<?=__('dev_blog_add_submit')?>">

    </fieldset>
  </form>

  <?php if(isset($_POST['devblog_add_preview'])) { ?>

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