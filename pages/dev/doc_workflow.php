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
$css  = array('dev');
$js   = array('common/selector');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page section selector

// Define the dropdown menu entries
$workflow_selector_entries = array( 'git'                 ,
                                    'tags'                ,
                                    'server_maintenance'  ,
                                    'server_issues'       ,
                                    'server_setup'        ,
                                    'aliases'             );

// Define the default dropdown menu entry
$workflow_selector_default = 'git';

// Initialize the page section selector data
$workflow_selector = page_section_selector(           $workflow_selector_entries  ,
                                            default:  $workflow_selector_default  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center section_selector_container">

  <fieldset>
    <h5>
      <?=__('submenu_admin_doc_workflow').__(':')?>
      <select class="inh" id="dev_workflow_selector" onchange="page_section_selector('dev_workflow', '<?=$workflow_selector_default?>');">
        <option value="git"<?=$workflow_selector['menu']['git']?>><?=__('dev_workflow_selector_git')?></option>
        <option value="tags"<?=$workflow_selector['menu']['tags']?>><?=__('dev_workflow_selector_tags')?></option>
        <option value="server_maintenance"<?=$workflow_selector['menu']['server_maintenance']?>><?=__('dev_workflow_selector_server_maintenance')?></option>
        <option value="server_issues"<?=$workflow_selector['menu']['server_issues']?>><?=__('dev_workflow_selector_server_issues')?></option>
        <option value="server_setup"<?=$workflow_selector['menu']['server_setup']?>><?=__('dev_workflow_selector_server_setup')?></option>
        <option value="aliases"<?=$workflow_selector['menu']['aliases']?>><?=__('dev_workflow_selector_aliases')?></option>
      </select>
    </h5>
  </fieldset>

</div>

<hr>




<?php /********************************************** GIT WORKFLOW ************************************************/ ?>

<div class="width_50 padding_top dev_workflow_section<?=$workflow_selector['hide']['git']?>" id="dev_workflow_git">

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
    Work in a new branch
  </h5>

  <pre>git switch -c $branch</pre>

  <p>
    Name the branch in an explicit way, related to the work being done.<br>
    When in doubt, the corresponding task number can be used as the branch name.
  </p>

  <h5 class="bigpadding_top">
    Publish code changes
  </h5>

  <p class="smallpadding_bot">
    Commit and push your changes.
  </p>

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
    Locally, switch to the <span class="monospace">trunk</span> branch and ensure that everything has been properly updated.
  </p>

  <pre>git checkout trunk
gitpull
git reset --hard origin/trunk
gitlog</pre>

  <p class="smallpadding_bot">
    Delete the straggler local branch if you have no plans to keep using it.
  </p>

  <pre>git branch -d $branch</pre>

  <p class="smallpadding_bot">
    If the remote branch is still present, delete it aswell
  </p>

  <pre>git push origin -d $branch</pre>

  <h5 class="bigpadding_top">
    Deploy the changes
  </h5>

  <p>
    Make sure that the code has been deployed and tested, including <?=__link('https://nobleme.com/pages/dev/queries', "queries", is_internal: false, popup: true)?> if needed.<br>
    You might want to <?=__link('https://nobleme.com/pages/dev/settings', "close", is_internal: false, popup: true)?> then <?=__link('https://nobleme.com/pages/dev/settings', "reopen", is_internal: false, popup: true)?> the website if your update contains major changes.
  </p>

  <p>
    Find the appropriate tasks in the <?=__link('https://nobleme.com/pages/tasks/roadmap', "roadmap", is_internal: false, popup: true)?> or the <?=__link('https://nobleme.com/pages/tasks/list', "to-do list", is_internal: false, popup: true)?> and mark them as solved.
  </p>

</div>




<?php /******************************************* TAGS AND VERSIONS **********************************************/ ?>

<div class="width_50 padding_top dev_workflow_section<?=$workflow_selector['hide']['tags']?>" id="dev_workflow_tags">

  <h5>
    Should I release a new version?
  </h5>

  <p>
    Release a new version only for new features, major bugfixes, or significant refactors.<br>
    Do not release a new version for hotfixes, small bug fixes, tweaks, or minor cosmetic changes.
  </p>

  <p>
    MAJOR releases should only be for significant core reworks.<br>
    MINOR releases should correspond to a new major functionality.<br>
    PATCH releases should correspond to a new minor functionality or major bugfix.<br>
    EXTENSION releases should only be used for alpha/beta testing of major or minor releases.

  <h5 class="bigpadding_top">
    Git tag
  </h5>

  <p>
    Find the next version number to use <?=__link('https://nobleme.com/pages/dev/versions', "on the website", is_internal: false, popup: true)?> and confirm it by running <?=__link('pages/dev/doc_workflow?aliases', "gitlog")?>.
  </p>

  <p class="smallpadding_bot">
    Tag the new version in the Git repository.
  </p>

  <pre>git tag $tag
gitpush
gitlog</pre>

  <p>
    Ensure that the tag has properly been created and pushed <?=__link('https://github.com/EricBisceglia/NoBleme.com/tags', "on GitHub", is_internal: false, popup: true)?>.
  </p>

  <h5 class="bigpadding_top">
    Version number
  </h5>

  <p>
    Publish the corresponding version number <?=__link('https://nobleme.com/pages/dev/versions', "on the website", is_internal: false, popup: true)?>.
  </p>

</div>




<?php /******************************************* SERVER MAINTENANCE *********************************************/ ?>

<div class="width_50 padding_top dev_workflow_section<?=$workflow_selector['hide']['server_maintenance']?>" id="dev_workflow_server_maintenance">

  <h5>
    Manual MySQL backup
  </h5>

  <p class="smallpadding_bot">
    Run this command then use SCP to fetch the database dump in the /tmp/ folder.
  </p>

  <pre>mysqldump -u root -p nobleme > /tmp/nobleme.sql</pre>

</div>




<?php /********************************************* SERVER ISSUES ************************************************/ ?>

<div class="width_50 padding_top dev_workflow_section<?=$workflow_selector['hide']['server_issues']?>" id="dev_workflow_server_issues">

  <h5>
    SSH key warning
  </h5>

  <p class="smallpadding_bot">
    Run this command locally if faced with an issue regarding host authenticity.
  </p>

  <pre>ssh-keygen -R nobleme.com</pre>

</div>




<?php /********************************************** SERVER SETUP ************************************************/ ?>

<div class="width_50 padding_top dev_workflow_section<?=$workflow_selector['hide']['server_setup']?>" id="dev_workflow_server_setup">

  <h5>
    Foreword
  </h5>

  <p>
    These are very broad guidelines.
  </p>

  <p>
    Don't follow them blindly, and be ready to adapt.<br>
    Some issues you might encounter are documented in <?=__link('pages/dev/doc_workflow?server_issues', "server issues")?>.
  </p>

  <h5 class="bigpadding_top">
    Initialization
  </h5>

  <p>
    Install Fedora on a server.
  </p>

  <p class="smallpadding_bot">
    Connect to the server using <span class="monospace">ssh</span>.<br>
  </p>

  <pre>ssh username@machine-ip</pre>

  <p class="smallpadding_bot">
    In case of error message when attempting to connect to the server, regen your local ssh key.
  </p>

  <pre>ssh-keygen -R machine-ip</pre>

  <p class="smallpadding_bot">
    Change the password of both <span class="monospace">root</span> and your user, then test the new root password.
  </p>

  <pre>sudo passwd
passwd
exit
ssh root@machine-ip</pre>

  <h5 class="bigpadding_top">
    Nano
  </h5>

  <p class="smallpadding_bot">
    A text editor will be needed for some upcoming steps, nano will do.
  </p>

  <pre>sudo dnf update -y
sudo dnf install nano</pre>

  <h5 class="bigpadding_top">
    Firewalld
  </h5>

  <p class="smallpadding_bot">
    A simple firewall is a must have.
  </p>

  <pre>sudo dnf install firewalld
sudo systemctl start firewalld
sudo systemctl status firewalld
sudo systemctl enable firewalld</pre>

  <h5 class="bigpadding_top">
    Fail2ban
  </h5>

  <p class="smallpadding_bot">
    Necessary to protect from password guessing flood.
  </p>

  <pre>sudo dnf install fail2ban-all
sudo systemctl start fail2ban.service
sudo systemctl status fail2ban.service
sudo systemctl enable fail2ban.service</pre>

  <h5 class="bigpadding_top">
    Apache
  </h5>

  <p class="smallpadding_bot">
    Install the apache webserver and enable it in firewalld.
  </p>

  <pre>sudo dnf install httpd
sudo systemctl start httpd.service
sudo systemctl status httpd.service
sudo systemctl enable httpd.service
sudo firewall-cmd --add-service={http,https} --permanent
sudo firewall-cmd --add-port={80,443}/tcp --permanent
sudo firewall-cmd --reload</pre>

  <p>
    Create a .html file in <span class="monospace">/var/www/html/</span> and test that Apache is working.<br>
  </p>

  <p class="smallpadding_bot">
    Enable .htaccess modifications in <span class="monospace">/var/www/html/</span> by editing Apache's configuration file.
  </p>

  <pre>sudo nano /etc/httpd/conf/httpd.conf

&lt;Directory "/var/www/html">
  AllowOverride All
&lt;/Directory></pre>

  <p class="smallpadding_bot">
    Create an Apache configuration file for the website.
  </p>

  <pre>sudo nano /etc/httpd/conf.d/yourdomain.conf

&lt;VirtualHost *:80>
  ServerAdmin your@email.com
  ServerName yourdomain.com
  ServerAlias *.yourdomain.com
  DocumentRoot /var/www/html
&lt;/VirtualHost></pre>

  <p class="smallpadding_bot">
    Rehash the configuration by restarting Apache.
  </p>

  <pre>sudo systemctl restart httpd.service</pre>

  <p>
    Test that the .html file in <span class="monospace">/var/www/html/</span> is still working.<br>
    If it still works, delete it.
  </p>

  <h5 class="bigpadding_top">
    PHP
  </h5>

  <p class="smallpadding_bot">
    Install PHP-FPM.
  </p>

  <pre>sudo dnf install php
sudo systemctl start httpd.service
sudo systemctl status httpd.service
sudo systemctl enable httpd.service</pre>

  <p>
    If the version of PHP available in dnf is too old, look up and setup a private repository.
  </p>

  <p class="smallpadding_bot">
    Install some PHP extensions and restart Apache to enable PHP-FPM.
  </p>

  <pre>sudo dnf install php-{mysqli,mysqlnd,zip,gd,xml,bcmath,json}
sudo systemctl restart httpd.service</pre>

  <p>
    Create a .php file in <span class="monospace">/var/www/html/</span> containing <span class="monospace">&lt;?php phpinfo(); ?></span>, check that everything works.
  </p>

  <p class="smallpadding_bot">
    Update PHP's configuration then reboot php-fpm to apply the changes.
  </p>

  <pre>sudo nano /etc/php.ini

upload_max_filesize = 128M

sudo systemctl restart php-fpm</pre>

  <p>
    Test that the .php file in <span class="monospace">/var/www/html/</span> still works and shows updated values.<br>
    If it works, delete it.
  </p>

  <h5 class="bigpadding_top">
    MySQL
  </h5>

  <p class="smallpadding_bot">
    Install MySQL, update the value of <span class="monospace">sql_mode</span> in its configuration, then start it.
  </p>

  <pre>sudo dnf install community-mysql-server

sudo nano /etc/my.cnf.d/community-mysql-server.cnf

[mysqld]
sql_mode=NO_ENGINE_SUBSTITUTION

sudo systemctl start mysqld.service
sudo systemctl status mysqld.service
sudo systemctl enable mysqld.service</pre>

  <p class="smallpadding_bot">
    Create the MySQL root account then test whether it works.
  </p>

  <pre>sudo mysql_secure_installation

mysql --user root -p --execute "select version()"</pre>

  <h5 class="bigpadding_top">
    PhpMyAdmin
  </h5>

  <p class="smallpadding_bot">
    If you want phpMyAdmin, you can optionally install it.<br>
    If you skip this step, manually create a <span class="monospace">nobleme</span> database and import NoBleme's schema into it.<span>
  </p>

  <pre>sudo dnf install phpMyAdmin</pre>

  <p class="smallpadding_bot">
    Change phpMyAdmin's URL in Apache configuration in order to slightly improve security.
  </p>

  <pre>sudo nano /etc/httpd/conf.d/phpMyAdmin.conf

Alias /SomeSecureName /usr/share/phpmyadmin

&lt;Directory /user/share/phpMyAdmin/>
  Require all granted
&lt;/Directory>

sudo systemctl restart httpd.service</pre>

  <p>
    Access phpMyAdmin on the newly configured URL, then switch language to english.<br>
    Create a blank database called <span class="monospace">nobleme</span> with encoding <span class="monospace">utf8mb4_unicode_ci</span>.<br>
    Manually import NoBleme's schema through phpMyAdmin.<br>
  </p>

  <h5 class="bigpadding_top">
    Website
  </h5>

  <p class="smallpadding_bot">
    Connect using sftp and upload NoBleme's files in <span class="monospace">/var/www/html/</span>
  </p>

  <pre>sftp username@nobleme.com</pre>

  <p class="smallpadding_bot">
    Configure NoBleme and apply the correct file and folder permissions.
  </p>

  <pre>sudo nano /var/www/html/conf/configuration.inc.php

sudo chmod -R 777 /var/www/html/img/compendium/
sudo chmod -R 777 /var/www/html/ircbot.txt
sudo chown apache /var/www/html/ircbot.txt</pre>

  <p>
    Test that the website is working properly.<br>
    Make sure to test logging in as an user.
  </p>

  <h5 class="bigpadding_top">
    Https
  </h5>

  <p class="smallpadding_bot">
    Install certbot and let it do its thing.
  </p>

  <pre>sudo dnf -y install certbot-apache
sudo certbot --apache
sudo certbot renew --dry-run
sudo systemctl restart httpd.service</pre>

  <p>
    Test that https is working properly on the website.<br>
    Make sure to test logging in as an user.
  </p>

  <h5 class="bigpadding_top">
    IRC
  </h5>

  <p class="smallpadding_bot">
    Install UnrealIRCd and enable it in firewalld.
  </p>

  <pre>sudo dnf install unrealircd
sudo firewall-cmd --add-port={6697,6667,7000}/tcp --permanent
sudo firewall-cmd --reload</pre>

  <p class="smallpadding_bot">
    Configure the IRC server and ensure that your configuration is valid.
  </p>

  <pre>sudo nano /etc/unrealircd/unrealircd.conf
/bin/unrealircdctl configtest</pre>

  <p class="smallpadding_bot">
    Start UnrealIRCd.
  </p>

  <pre>sudo systemctl start unrealircd.service
sudo systemctl status unrealircd.service
sudo systemctl enable unrealircd.service</pre>

  <p>
    If UnrealIRCd is refusing to start, reboot the server and try again.<br>
    Ensure that the IRC server is working properly.
  </p>

  <p>
    If you want proper SSL support, you might require extra setup steps.<br>
    Look up how to setup Certbot for use with UnrealIRCd in their documentation.
  </p>

  <p class="smallpadding_bot">
    Add IRC services by installing Anope.
  </p>

  <pre>sudo dnf install anope</pre>

  <p class="smallpadding_bot">
    Configure and enable Anope, then restart UnrealIRCd.
  </p>

  <pre>sudo nano /etc/anope/services.conf
sudo systemctl start anope.service
sudo systemctl status anope.service
sudo systemctl enable anope.service
/bin/unrealircdctl restart</pre>

  <p>
    Ensure that IRC services are working properly by registering your account with NickServ.
  </p>

  <h5 class="bigpadding_top">
    Cron
  </h5>

  <p class="smallpadding_bot">
    Install and enable cronie.
  </p>

  <pre>sudo dnf install cronie cronie-anacron
sudo systemctl start crond.service
sudo systemctl status crond.service
sudo systemctl enable crond.service</pre>

  <h5 class="bigpadding_top">
    Automated MySQL backups
  </h5>

  <p class="smallpadding_bot">
    Install zip.
  </p>

  <pre>sudo dnf install zip</pre>

  <p class="smallpadding_bot">
    Create and test a shell script for automated backups - edit the variables as necessary.
  </p>

  <div class="smallpadding_bot">
    <pre>mkdir /var/mysql-backups/
sudo nano /usr/bin/mysql-backup.sh
sudo chmod u+r+x /usr/bin/mysql-backup.sh
/usr/bin/mysql-backup.sh</pre>
  </div>

  <pre># Variables
backupfolder=/var/mysql-backups
user=your_system_user
password=your_mysql_password
keep_backup_days=30

# Determine file names
sqlfile=$backupfolder/mysql-backup-$(date +%y-%m-%d-%H-%M).sql
zipfile=$backupfolder/mysql-backup-$(date +%y-%m-%d-%H-%M).zip

# Create and compress backup
sudo mysqldump -u $user -p$password --all-databases > $sqlfile
zip $zipfile $sqlfile
rm $sqlfile

# Delete old backups
find $backupfolder -mtime +$keep_backup_days -delete</pre>

  <p class="smallpadding_bot">
    Make the script run daily through a cronjob.
  </p>

  <pre>sudo nano /etc/crontab

0 3 * * * root /usr/bin/mysql-backup.sh</pre>

  <h5 class="bigpadding_top">
    Testing
  </h5>

  <p>
    Reboot and make sure every service starts and works as intended.
  </p>

  <p>
    If you imported NoBleme's default schema, give your account admin rights in the <span class="monospace">users</span> table.
  </p>

  <p class="tinypadding_bot">
    Finish by testing everything thoroughly, including:
  </p>

  <ul>
    <li>
      Logging in on the website.
    </li>
    <li>
      Uploading an image in the compendium.
    </li>
    <li>
      Sending a message through the Discord webhook.
    </li>
    <li>
      Starting the IRC bot and sending a message with it.
    </li>
  </ul>

</div>




<?php /************************************************* ALIASES **************************************************/ ?>

<div class="width_50 padding_top dev_workflow_section<?=$workflow_selector['hide']['aliases']?>" id="dev_workflow_aliases">

  <h5>
    Git aliases
  </h5>

  <p class="padding_bot">
    These aliases will simplify the <?=__link('pages/dev/doc_workflow?git', "Git workflow")?> and should be placed in your <span class="monospace">~/.bash_profile</span> file.
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