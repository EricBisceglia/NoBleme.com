NoBleme's source code
===

This repository contains the source code of [NoBleme.com](http://nobleme.com).

NoBleme was started in 2005 - old enough to make it older than YouTube. It is developed in purely procedural PHP, and has been consistently maintained and refactored on a regular basis ever since. Even though its source code has been modernized throughout the development process, its heart still relies on ancient (but safe and stable) technology. There is no plan to ever change the language or the coding style, NoBleme is and will remain a showcase that oldschool monolithic fully procedural vanilla PHP can still be used to produce modern content.

Despite its age, the codebase has been designed from the start with readability in mind: The code is well indented, comments show the logical train of thought of every file, and the code logic is split within files by huge comment blocks. Scroll further down this readme for an explanation of how the codebase should be read.

NoBleme is open sourced for educative and collaborative reasons. Furthermore, the license (MIT) allows you to reuse code from NoBleme if you so desire, as long as you credit the original author in your codebase: Copyright (c) 2005 Eric Bisceglia / NoBleme.com.

 

Local installation guide
===

Installing a local copy of NoBleme is meant to be simple and intuitive as long as you've ever installed a barebones PHP project on your machine before. Don't worry, if you haven't, it's not *that* hard, it just requires a little bit of patience.

Installing a pre-assembled LAMP/MAMP/WAMP stack (depending on your OS) will let you skip the first 3 steps of the installation process below:

1. Have Apache 2.2 or above running locally (NoBleme relies heavily on .htaccess files, can't run it on nginx).

2. Have PHP 8.0 or above installed and working within Apache.

3. Have MySQL 8.0 or above installed and running, create an empty database named `nobleme` with the `utf8mb4` charset.

4. Clone the source code of NoBleme (checkout the `trunk` branch for the current production release) and place it anywhere in your local `www` folder.

5. Rename `/conf/main.conf.php.DEFAULT` to `/conf/main.conf.php` and edit the file's contents to match your local setup.

6. Run the file called `fixtures.php` in your browser, it is located at the root of the project and will initialize the database.

7. Run the file called `tests.php` in your browser, it is located at the root of the project and will confirm everything is working as intended.

This is it, you now have a working local copy of NoBleme. It's that simple! Everything's here, including randomly generated data for most features of the website. Try logging in as either one of the demo users, they're useful when testing features that rely on user permissions, they require no passwords (as long as `dev_mode` is enabled in `main.conf.php`) and their nicknames are: `Banned`, `User`, `Prude`, `Mod`, and `Admin`.

In case the `main.conf.php` part is overwhelming, it might help you if I shared what my local configuration looks like in my own development environment:

```
$GLOBALS['website_url']       = 'http://localhost/nobleme/';
$GLOBALS['domain_name']       = 'nobleme.dev';
$GLOBALS['mysql_host']        = 'localhost';
$GLOBALS['mysql_user']        = 'root';
$GLOBALS['mysql_pass']        = '';
$GLOBALS['salt_key']          = '$6$somestring$';
$GLOBALS['extra_folders']     = 1;
$GLOBALS['enable_irc_bot']    = 0;
$GLOBALS['enable_discord']    = 0;
$GLOBALS['dev_mode']          = 0;
$GLOBALS['dev_http_only']     = 1;
$GLOBALS['env_debug_mode']    = 0;
$GLOBALS['sql_debug_mode']    = 0;
$GLOBALS['full_debug_mode']   = 0;
```

 

Scheduled tasks (optional)
===

Some of the website's features require running scheduled tasks. If you want to use scheduled tasks, follow these steps:

1. Edit the first line of code in `/scripts/scheduler.php`: change `$root_path` to the website's root path on your web server.

2. Add a command regularly running the scheduler to your crontab. Running it every minute is suggested but any other interval will work just as well. On my server, the cron line looks like this: `* * * * * myusername php /var/www/html/scripts/scheduler.php`.

3. Check whether the scheduler is properly running through the user interface, each execution will leave a log on `/pages/dev/scheduler`.

 

Integrations (optional)
===

If you wish to make the third party integrations work, you will need to fiddle around a bit. These are the steps to follow:

1. Rename `/conf/integrations.conf.php.DEFAULT` to `/conf/integrations.conf.php` and edit te file to match your integrations.

2. Test the Discord integration through the user interface on `/pages/dev/discord`.

3. Edit the first line of code in `/scripts/irc_bot.php`: change `$root_path` to the website's root path on your web server.

4. Boot the IRC bot through the user interface on `/pages/dev/irc_bot`.

 

Editor setup
===

The codebase is designed with the following editor settings in mind:

* Line width of 120 (many decorations in the codebase have a width of 119 characters).

* Indentation 2 spaces wide, no tabs (no let's not have this debate).

For the best source code reading and writing experience, it is recommended that your text editor follow these two settings.

Any contributions to the project are expected to respect those settings (no tabs, indent width 2, max line width 119).

 

Understanding the codebase
===

Hopefully, the source code will be commented well enough that you should have no issue understanding what each page does by simply following the comments. As for being able to understand the codebase's structure, it all becomes clearer once you grasp the role of each of the folders at the root of the project:

* `actions` makes sense if you think of it as kind of a pre-MVC controller concept, all actions (get, list, create, edit, delete, etc.) are placed in this folder and called when necessary by the other pages.

* `api` contains the routes of the website's REST API and their documentation (they use the logic from `actions`).

* `conf` contains the configuration files, which must be set up properly before running the project.

* `css` contains all the CSS files used on the website (`reset.css` and `nobleme.css` are core files).

* `dev` contains dev tools and utilities, for local usage only.

* `img` contains all the images required to make the website look right.

* `inc` is the applicative heart of the website, all of the core functions and most of the shared logic are in here.

* `js` contains all the JavaScript used on the website (the `common` folder is shared by multiple website sections).

* `lang` contains all translations and templates (`common.lang.php` contains the core logic for them).

* `pages` contains all of the views, the HTML layouts which the users are browsing (they use the logic from `actions`).

* `scripts` contains scripts which get executed by the PHP command line instead of the web server.

* `test` contains testswhich are executed by the `tests.php` page at the root of the project.

With this understanding of the folder structure, you should be able to follow how the components of each page are split. To summarize: the core is in `inc`, actions happen in `actions`, views are in `pages` + `css` + `js`, and translations are in `lang`.

 

Contributing to the codebase
===

Contributors are welcome! There's always bugs to be fixed, refactoring to be done, and features to be added.

Before contributing, please read the `CONTRIBUTING.md` file at the root of this repository.

 

Code of conduct: be excellent to each other
===

Any activity done around this repository should be done in a mutually respectful way.

This is why there is a `CODE_OF_CONDUCT.md` file at the root of the repository.

 

License: Can I re-use your code?
===

You will find a `LICENSE.md` file at the root of the repository.

This project is under the MIT license, which is extremely permissive: you can re-use code as is, anywhere you want, without asking for permission beforehand. Yes, you can even use it in commercial software. All that is asked in return is that you credit the original author of the pieces of code that you re-use: Copyright (c) 2005 Eric Bisceglia / NoBleme.com. See the license itself for more details - it's a very short read.

 

Something went wrong
===

If you're stuck trying to read, setup, or use this codebase, you can always visit the #dev channel of [NoBleme's IRC server](https://nobleme.com/pages/social/irc). Ask your questions, be very patient (timezones and private lives might get in the way), and someone should eventually help you out.

NoBleme is a welcoming community, so don't be scared - just hop on IRC and ask away. There is no shame in being stuck, and bug reports are more than welcome.