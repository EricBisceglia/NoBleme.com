<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare the footer's contents

// Current pageview count
$pageviews = isset($pageviews) ? __('footer_pageviews').$pageviews.__('times', $pageviews, 1) : "";

// Load time and query count
$load_time  = round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 3).'s';
$metrics    = __('footer_loadtime').$load_time.__('with', 1, 1, 1).$GLOBALS['query'].__('query', $GLOBALS['query'], 1);

// Current version
$dversion = mysqli_fetch_array(query("  SELECT    system_versions.version AS 'v_version'  ,
                                                  system_versions.build   AS 'v_build'    ,
                                                  system_versions.date    AS 'v_date'
                                        FROM      system_versions
                                        ORDER BY  system_versions.id DESC LIMIT 1 "));
$version = __('version', 1, 0, 1).$dversion['v_version'].",".__('build', 1, 1, 1).$dversion['v_build'].__('footer_version_prefix', 1, 1, 1).date_to_text($dversion['v_date'], $lang, 1);

// Copyright ending date
$copyright_date = date('Y');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                DISPLAY THE FOOTER                                                 */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

      <!-- ################################  FOOTER  ################################ -->

      <?php
      # Do not show the footer if the page is a popup or is called through xhr
      if(!isset($_GET["popup"]) && !isset($_GET["xhr"])) {
      ?>

      <footer>

        <?php
        # If the page can be called through a short URL, display it in the footer
        if(isset($shorturl)) {  ?>

        <a href="<?=$path?>s?<?=$shorturl?>">
          <?=__('footer_shorturl')?>
        </a><br>

        <?php
        # If the user is an admin, show metrics for this page
        } if($is_admin) { ?>

        <a href="<?=$path?>pages/admin/pageviews">
          <?=$pageviews?>
        </a><br>

        <a>
          <?=$metrics?>
        </a><br>

        <?php } ?>

        <?php
        # Footer concludes with version number, legal mentions, and copyright notice ?>

        <a href="<?=$path?>pages/todo/roadmap">
          <?=$version?>
        </a><br>

        <a href="<?=$path?>pages/doc/mentions_legales">
          <?=__('footer_legal')?>
        </a><br>

        <a href="<?=$path?>pages/doc/nobleme">
          &copy; NoBleme.com : 2005 - <?=$copyright_date?>
        </a>

      </footer>

    <?php
    # The time has come to close the divs that set up the layout of the page (header and side menu) ?>

    </div>
  </div>

  <?php
  # End of the conditions for potentially hiding the footer (popup or xhr)
  } ?>

  </body>
</html>