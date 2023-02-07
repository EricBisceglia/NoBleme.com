<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare the footer's contents

// Current pageview count
$pageviews = isset($pageviews) ? __('footer_pageviews').$pageviews.__('times', $pageviews, 1) : '';

// Current version
$version = system_get_current_version_number('full');

// Load time and query count
$load_time  = round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 3);
$metrics    = __('footer_loadtime').$load_time.'s'.__('with', 1, 1, 1).$GLOBALS['query'].__('query', $GLOBALS['query'], 1);

// Copyright ending date
$copyright_date = date('Y');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update the page's metrics

if(isset($page_url) && !isset($error_mode))
{
  // Sanitize the data
  $timestamp            = sanitize(time(), 'int');
  $page_url_sanitized   = sanitize($page_url, 'string');
  $queries_sanitized    = sanitize($GLOBALS['query'], 'int');
  $load_time_sanitized  = sanitize(($load_time * 1000), 'int');

  // Update the page stats
  query(" UPDATE  stats_pages
          SET     stats_pages.last_viewed_at  = '$timestamp'          ,
                  stats_pages.query_count     = '$queries_sanitized'  ,
                  stats_pages.load_time       = '$load_time_sanitized'
          WHERE   stats_pages.page_url     LIKE '$page_url_sanitized' ",
          description: "Update statistics related to page usage");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Debug mode

// In full debug mode, print all variables in footer
if($GLOBALS['dev_mode'] && $GLOBALS['full_debug_mode'])
  var_dump(get_defined_vars());




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                DISPLAY THE FOOTER                                                 */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

      <?php if(!isset($hide_footer)) { ?>

      <footer>

        <?=__link("pages/tasks/roadmap", string_change_case(__('version'), 'initials').' '.$version, "", 1, $path);?><br>

        <?php if($is_admin) { ?>

        <?php if($pageviews) { ?>

        <?=__link("pages/admin/stats_views", $pageviews, "", true, $path);?><br>

        <?php } ?>

        <?=__link("pages/admin/stats_metrics", $metrics, "", true, $path);?><br>

        <?php } ?>

        <?=__link("pages/doc/privacy", __('footer_legal'), "", true, $path);?><br>

        <?=__link("pages/doc/legal", __('footer_copyright', preset_values: array($copyright_date)), "", true, $path);?><br>

      </footer>

    </div>

    <?php } ?>

  </body>
</html>