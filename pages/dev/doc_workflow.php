<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php'; # Core
include_once './../../lang/dev.lang.php';    # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/doc_workflow";
$page_title_en    = "Development workflow";
$page_title_fr    = "Workflow de développement";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h2>
    <?=__('submenu_admin_doc_workflow')?>
  </h2>

  <h5 class="padding_top smallpadding_bot">
    <?=__('dev_workflow_preliminary_title')?>
  </h5>

  <pre>git checkout trunk
gitpull
git reset --hard origin/trunk
gitlog</pre>

  <p>
    <?=__('dev_workflow_preliminary_body')?>
  </p>

  <h5 class="bigpadding_top smallpadding_bot">
    <?=__('dev_workflow_branch_title')?>
  </h5>

  <pre>git checkout -b $<?=__('dev_workflow_branch')?></pre>

  <p>
    <?=__('dev_workflow_branch_body')?>
  </p>

  <h5 class="bigpadding_top smallpadding_bot">
    <?=__('dev_workflow_commit_title')?>
  </h5>

  <pre>git add .
git commit
gitpush</pre>

  <p>
    <?=__('dev_workflow_commit_body')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('dev_workflow_testing_title')?>
  </h5>

  <p>
    <?=__('dev_workflow_testing_body')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('dev_workflow_pr_title')?>
  </h5>

  <p class="padding_bot">
    <?=__('dev_workflow_pr_body_1')?>
  </p>

  <pre>git checkout trunk
gitpull
git reset --hard origin/trunk
gitlog</pre>

  <p class="padding_bot">
    <?=__('dev_workflow_pr_body_2')?>
  </p>

  <pre>git branch -d $<?=__('dev_workflow_branch')?></pre>

  <h5 class="bigpadding_top">
    <?=__('dev_workflow_nobleme_title')?>
  </h5>

  <p>
    <?=__('dev_workflow_nobleme_body')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('dev_workflow_version_title')?>
  </h5>

  <p class="padding_bot">
    <?=__('dev_workflow_version_body_1')?>
  </p>

  <pre>git tag $<?=__('dev_workflow_tag')?> 
gitpush
gitlog</pre>

  <p>
    <?=__('dev_workflow_version_body_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('dev_workflow_aliases_title')?>
  </h5>

  <p class="padding_bot">
    <?=__('dev_workflow_aliases_body')?>
  </p>

  <pre id="doc_workflow_git_aliases" onclick="to_clipboard('', 'doc_workflow_git_aliases', 1);">alias gitlog="git log --graph --abbrev-commit --decorate --format=format:'%C(bold blue)%h%C(reset) - %C(bold green)(%ar)%C(reset) %C(white)%s%C(reset) %C(dim white)- %an%C(reset)%C(bold yellow)%d%C(reset)' --all;"
alias gitlog2="git log --graph --abbrev-commit --decorate --format=format:'%C(bold blue)%h%C(reset) - %C(bold green)(%ar)%C(reset) %C(white)%s%C(reset) %C(dim white)- %an%C(reset)%C(bold yellow)%d%C(reset)';"
alias gitpull='git fetch --all; git fetch -p;'
alias gitpush='git push origin --all; git push origin --tags;'
alias gitstatus='git status -s;'
alias gitdiff='git diff --cached;'</pre>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }