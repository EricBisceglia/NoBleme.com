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

// Extra CSS & JS
$js = array('dev/doc', 'common/toggle');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Display the correct workflow reminder entry

// Prepare a list of all workflow reminders
$dev_workflow_selection = array('git', 'aliases');

// Prepare the CSS for each workflow reminder
foreach($dev_workflow_selection as $dev_workflow_selection_name)
{
  // If a workflow reminders is selected, display it and select the correct dropdown menu entry
  if(!isset($dev_workflow_is_selected) && isset($_GET[$dev_workflow_selection_name]))
  {
    $dev_workflow_is_selected                             = true;
    $dev_workflow_hide[$dev_workflow_selection_name]      = '';
    $dev_workflow_selected[$dev_workflow_selection_name]  = ' selected';
  }

  // Hide every other workflow reminders
  else
  {
    $dev_workflow_hide[$dev_workflow_selection_name]      = ' hidden';
    $dev_workflow_selected[$dev_workflow_selection_name]  = '';
  }
}

// If no workflow reminders is selected, select the main one by default
if(!isset($dev_workflow_is_selected))
{
  $dev_workflow_hide['git']     = '';
  $dev_workflow_selected['git'] = ' selected';
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center dev_doc_selector">

  <fieldset>
    <h5>
      <?=__('submenu_admin_doc_workflow').__(':')?>
      <select class="inh" id="dev_workflow_selector" onchange="dev_workflow_selector();">
        <option value="git"<?=$dev_workflow_selected['git']?>><?=__('dev_workflow_selector_git')?></option>
        <option value="aliases"<?=$dev_workflow_selected['aliases']?>><?=__('dev_workflow_selector_aliases')?></option>
      </select>
    </h5>
  </fieldset>

</div>

<hr>




<?php /********************************************** GIT WORKFLOW ************************************************/ ?>

<div class="width_50 padding_top dev_workflow_section<?=$dev_workflow_hide['git']?>" id="dev_workflow_git">

  <h5>
    Preliminary checks
  </h5>

  <p class="smallpadding_bot">
    Custom <?=__link('pages/dev/doc_workflow?aliases', "Git aliases")?> will be used throughout this workflow.
  </p>

  <pre>git checkout trunk
gitpull
git reset --hard origin/trunk
gitlog</pre>

  <p>
    Resets the repository to its remote state. Ensure that everything looks correct.
  </p>

  <h5 class="bigpadding_top smallpadding_bot">
    Working in a new branch
  </h5>

  <pre>git switch -c $branch</pre>

  <p>
    Name the branch in an explicit way, related to the work being done.<br>
    When in doubt, the corresponding task number can be used as the branch name.
  </p>

  <h5 class="bigpadding_top smallpadding_bot">
    Publishing code changes
  </h5>

  <pre>git add .
git commit
gitpush</pre>

  <p>
    Commit messages should be in english, be descriptive, use the present tense, and keep a neutral tone.
  </p>

  <ul class="italics tinypadding_top">
    <li>
      Add a stats page to meetups
    </li>
    <li>
      Fix description length in compendium categories
    </li>
    <li>
      Refactor the login function in order to improve security
    </li>
  </ul>

  <p class="tinypadding_top">
    Atomic commits are preferable to a flood of small commits or a single huge commit.
  </p>

  <h5 class="bigpadding_top">
    Pull request on GitHub
  </h5>

  <p class="padding_bot">
    On <?=__link('https://github.com/EricBisceglia/NoBleme.com/pulls?utf8=%E2%9C%93&q=is%3Apr', "NoBleme's GitHub", is_internal: false, popup: true)?>, create a pull request asking to merge your branch into <span class="monospace">trunk</span>.<br>
    Pull request title: A clear and concise summary the changes included in your branch.<br>
    Pull request description: Link to solved tasks <?=__link('https://nobleme.com/pages/tasks/list', "on the website", is_internal: false, popup: true)?> - do not link to private tasks.<br>
    <br>
    Once the pull request has been merged, press the "Delete branch" button on GitHub.<br>
    Locally, switch to the <span class="monospace">trunk</span> branch and ensure that everything has been properly updated:
  </p>

  <pre>git checkout trunk
gitpull
git reset --hard origin/trunk
gitlog</pre>

  <p class="padding_bot">
    Delete the straggler local branch if you have no plans to keep using it:
  </p>

  <pre>git branch -d $branch</pre>

  <h5 class="bigpadding_top">
    Updating the tasks on NoBleme
  </h5>

  <p>
    Make sure that the code has been deployed and tested, including <?=__link('https://nobleme.com/pages/dev/queries', "queries", is_internal: false, popup: true)?> if needed.<br>
    Find the appropriate tasks in the <?=__link('https://nobleme.com/pages/tasks/roadmap', "roadmap", is_internal: false, popup: true)?> or the <?=__link('https://nobleme.com/pages/tasks/list', "to-do list", is_internal: false, popup: true)?> and mark them as solved.<br>
  </p>

  <h5 class="bigpadding_top">
    New version number
  </h5>

  <p class="padding_bot">
    Release a new version only for major changes, not for hotfixes, tweaks, or minor cosmetic changes.<br>
    Find the next version number to use <?=__link('https://nobleme.com/pages/dev/versions', "on the website", is_internal: false, popup: true)?> and confirm it by running <span class="monospace">gitlog</span>.<br>
    Tag the new version in the Git repository:
  </p>

  <pre>git tag $tag
gitpush
gitlog</pre>

  <p>
    Ensure that the tag has properly been created and pushed <?=__link('https://github.com/EricBisceglia/NoBleme.com/tags', "on GitHub", is_internal: false, popup: true)?>.<br>
    Publish the corresponding version number <?=__link('https://nobleme.com/pages/dev/versions', "on the website", is_internal: false, popup: true)?>.
  </p>

</div>




<?php /************************************************* ALIASES **************************************************/ ?>

<div class="width_50 padding_top dev_workflow_section<?=$dev_workflow_hide['aliases']?>" id="dev_workflow_aliases">

  <h5>
    Git aliases
  </h5>

  <p class="padding_bot">
    These aliases will simplify the <?=__link('pages/dev/doc_workflow?git', "Git worflow")?> and should be placed in your <span class="monospace">~/.bash_profile</span> file.
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