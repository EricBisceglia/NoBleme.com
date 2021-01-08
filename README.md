NoBleme's source code
===

This repository contains the source code of [NoBleme.com](http://nobleme.com).

The website was started in 2005 - that's so old it makes it older than youtube -  developed in purely procedural PHP, then maintained and refactored on a regular basis ever since. Even though its source code has been modernized throughout the development process, its heart still relies on ancient (but safe and stable) technology. There is no plan to ever change the language or the coding style, NoBleme is and will remain a showcase of oldschool monolithic fully procedural vanilla PHP.

Despite its age, the codebase has been designed from the start with readability in mind: The code is well indented, comments show the logical train of thought of every file, and the code logic is split within files by huge comment blocks. Scroll further down this readme for an explanation of how the codebase should be read.

The website is open sourced for educative and collaborative reasons. Furthermore, the license (MIT) allows you to reuse code from NoBleme if you so desire, as long as you keep the license in your own codebase.

 

Local installation guide
===

Installing a local copy of NoBleme is meant to be simple and intuitive as long as you've ever installed a barebones PHP project on your machine before. Don't worry, if you haven't, it's not *that* hard, it just requires a little bit of research.

Installing a pre-assembled LAMP/MAMP/WAMP stack (depending on your OS) will let you skip the first 3 steps of the installation process below:

1. Have Apache 2.2 or above running locally (it is required, can't use nginx with NoBleme)

2. Have PHP 8.0 or above installed and working in Apache

3. Have MySQL 5.6 or above installed and running

4. Clone the source code of NoBleme (checkout the `develop` branch for the current production release)

5. Rename `/inc/configuration.inc.php.DEFAULT` to `/inc/configuration.inc.php` and edit the file's contents

6. Run in your browser the file called `fixtures.php` at the root of the project and let it initialize the database

This is it, you now have a working local copy of NoBleme. No, really, it's that simple, everything's here, including randomly generated data for most features of the website. The fixtures that have been inserted in your local database includes a bunch of users that you can use without passwords (as long as you have enabled `dev_mode` in the configuration file), so feel free to log in as either one of those when testing features that rely on user permissions: `Admin`, `Mod`, `User`, `Prude`, and `Banned`.

In case the `configuration.inc.php` part is overwhelming, here's what my local configuration looks like when working on my development environment, maybe it can help you understand anything confusing about it:

```
$GLOBALS['website_url']     = 'http://127.0.0.1/nobleme/';
$GLOBALS['domain_name']     = 'nobleme.com';
$GLOBALS['mysql_host']      = 'localhost';
$GLOBALS['mysql_user']      = 'root';
$GLOBALS['mysql_pass']      = '';
$GLOBALS['salt_key']        = '$6$somestring$';
$GLOBALS['irc_bot_pass']    = '';
$GLOBALS['extra_folders']   = 1;
$GLOBALS['dev_mode']        = 0;
$GLOBALS['env_debug_mode']  = 0;
$GLOBALS['sql_debug_mode']  = 0;
$GLOBALS['full_debug_mode'] = 0;
```

 

Editor setup
===

The codebase is designed with the following editor settings in mind:

* Maximum column width of 120 (many decorations in the codebase have a width of 119 characters)

* Indentation of width 2 using spaces only (no let's not have this debate)

For a best experience viewing the source code, it is recommended that your text editor be used with the above settings in mind.

Any contributions to the project are expected to respect those settings (no tabs, indent width 2, max line width 119).

 

Understanding the codebase
===

Hopefully, the code is well commented enough that you should have no issue understanding what each page does. As for being able to read the codebase, it all becomes clearer once you understand the role of each of the folders at the root of the project:

* `actions` makes sense if you think of it as kind of a pre-MVC controller concept, all actions (get, list, create, edit, delete, etc.) are placed in this folder and called when necessary by the other pages

* `api` contains the routes of the website's REST API (they use the logic from `actions`)

* `css` contains all the CSS files used on the website (`reset.css` and `nobleme.css` are the core files)

* `img` contains all the images used on the website (to make the project lighter, only the core ones are in the local copy)

* `inc` is the applicative core of the website, all of the functions and most of the core logic are in here

* `js` contains all the JS used on the website (the `common` folder is shared by multiple website sections)

* `lang` contains all translations and templates (`common.lang.php` contains the core logic for them)

* `pages` contains all of the views, this is what the users are browsing (they use the logic from `actions`)

With this understanding of which folder does what, you should be able to follow how the components of each page are split. To summarize: the core is in `inc`, actions happen in `actions`, views are in `pages` + `css` + `js`, and translations are in `lang`. That's it.

 

Contributing to the codebase
===

Contributors are welcome! There's always bugs to be fixed, refactoring to be done, and features to be added.

See the `CONTRIBUTING.md` file at the root of this repository for details on how you can contribute.

 

Code of conduct: be excellent to each other
===

Any activity done around this repository should be done in a way that is respectful to all other contributors.

This is why there is a `CODE_OF_CONDUCT.md` file at the root of the repository, which should be respected at all times.

 

License: Can I re-use your code?
===

You will find a `LICENSE.md` file at the root of the repository.

This project is under MIT license, which means that it is extremely permissive: you can re-use code as is, anywhere you want, without asking for permission. Yes, you can even use it in commercial software. All that is asked in return is that you credit the original author of the pieces of code that you re-use, just as I did for the few bits of code that I borrowed from other projects and used in this one (see the license itself for more details - it's a very short read).

 

Something went wrong
===

If you're stuck trying to read, install, or use this codebase, you can always visit the #dev channel of [NoBleme's IRC server](https://nobleme.com/todo_link). Ask your question, be very patient (timezones and private lives might be in the way), and someone should eventually help you out.

NoBleme is a welcoming community, so don't be scared - just hop on IRC and ask away. There's no shame in being stuck, and bug reports are more than welcome.