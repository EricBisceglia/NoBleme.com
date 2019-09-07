<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare the footer's contents

// Current pageview count
$pageviews = isset($pageviews) ? __('footer_pageviews').$pageviews.__('times', $pageviews, 1) : '';

// Load time and query count
$load_time  = round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 3).'s';
$metrics    = __('footer_loadtime').$load_time.__('with', 1, 1, 1).$GLOBALS['query'].__('query', $GLOBALS['query'], 1);

// Current version
$dversion = mysqli_fetch_array(query("  SELECT    system_versions.version AS 'v_version'  ,
                                                  system_versions.build   AS 'v_build'    ,
                                                  system_versions.date    AS 'v_date'
                                        FROM      system_versions
                                        ORDER BY  system_versions.id DESC LIMIT 1 "));
$version = sanitize_output(__('footer_version', 1, 0, 1, array($dversion['v_version'], $dversion['v_build'], date_to_text($dversion['v_date'], $lang, 1))));

// Copyright ending date
$copyright_date = date('Y');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                DISPLAY THE FOOTER                                                 */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

        <?php if(!isset($_GET["popup"]) && !isset($_GET["xhr"])) { ?>

        <footer>

          <?php if(isset($shorturl)) {  ?>

          <?=__link("s?".$shorturl, __('footer_shorturl'), "", 1, $path);?><br>

          <?php } if($is_admin) { ?>

          <?php if($pageviews) { ?>

          <?=__link("pages/admin/pageviews", $pageviews, "", 1, $path);?><br>

          <?php } ?>

          <?=__link("", $metrics, "pointer", 0, $path);?><br>

          <?php } ?>

          <?=__link("pages/todo/roadmap", $version, "", 1, $path);?><br>

          <?=__link("pages/doc/mentions_legales", __('footer_legal'), "", 1, $path);?><br>

          <?=__link("pages/doc/nobleme", __('footer_copyright', 0, 0, 0, array($copyright_date)), "", 1, $path);?><br>

        </footer>

      </div>
    </div>

    <?php } ?>

  </body>
</html>