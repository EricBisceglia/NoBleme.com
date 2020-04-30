<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare the footer's contents

// Current pageview count
$pageviews = isset($pageviews) ? __('footer_pageviews').$pageviews.__('times', $pageviews, 1) : '';

// Load time and query count
$load_time  = round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 3).'s';
$metrics    = __('footer_loadtime').$load_time.__('with', 1, 1, 1).$GLOBALS['query'].__('query', $GLOBALS['query'], 1);

// Current version
$version = system_get_current_version_number('full');

// Copyright ending date
$copyright_date = date('Y');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                DISPLAY THE FOOTER                                                 */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

      <?php if(!isset($_GET["popup"]) && !isset($nofooter)) { ?>

      <footer>

        <?=__link("todo_link", string_change_case(__('version'), 'initials').' '.$version, "", 1, $path);?><br>

        <?php if($is_admin) { ?>

        <?php if($pageviews) { ?>

        <?=__link("todo_link", $pageviews, "", 1, $path);?><br>

        <?php } ?>

        <?=__link("todo_link", $metrics, "pointer", 1, $path);?><br>

        <?php } ?>

        <?=__link("todo_link", __('footer_legal'), "", 1, $path);?><br>

        <?=__link("todo_link", __('footer_copyright', 0, 0, 0, array($copyright_date)), "", 1, $path);?><br>

      </footer>

    </div>

    <?php } ?>

  </body>
</html>