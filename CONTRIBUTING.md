Contributing to NoBleme.com
===

Contributors are welcome to contribute to NoBleme's source code, be it for a tiny bug fix, a refactor, or a new feature.

Before contributing, it is best that you first interact with NoBleme's community on the #dev channel of [NoBleme's IRC server](https://nobleme.com/pages/social/irc).

All contributions should be done by creating a branch of your own from `trunk`, then opening a pull request on the `trunk` branch on GitHub.

If your contribution is related to a task on [NoBleme's to-do list](https://nobleme.com/pages/tasks/list), include the task's ID in your branch name, and include both the task's ID and task's description in your pull request message.

 

Monolingual contributors
===

NoBleme is bilingual, the website is in both french and english, but it can obviously not be expected of everyone to master both languages when contributing.

If you want to provide a new feature, feel free to leave all the french translations empty. They will be filled in by someone else who speaks french fluently.

 

Coding style and guidelines
===

There is currently no written style guide for this project's source code. Instead, you should look at how things are currently done, and to do your best to imitate this style in your contributions. It can be summarized as such:

* 120 characters wide lines (119 characters per line max).

* Indentation levels of 2 spaces, no tabs (no, we won't have this conversation).

* Brackets on their own lines, indented to the level of their parent.

* Fully procedural code - no objects, jumps, or callbacks unless strictly necessary.

* Lots of comments explaining the thought process of every piece of code.

* A line jump before every comment.

* Big comment blocks separating the sections of source code files.

* 4 empty lines before every big comment block.

* Use `sanitize()` on any data before using it in MySQL queries.

* Use `query()` to execute your MySQL queries.

* MySQL queries are indented vertically... strange I know, look at previous queries for inspiration.

* Use website-provided functions over PHP stdlib functions whenever possible.

* Split the code: logic goes in `actions`, views in `pages`, and translations in `lang`.

* All of the codebase (comments, variable names, etc.) must be in english.

* All text displayed in pages must be declared as `lang` translations and be called through the `__()` function.

* All links should use the `__link()` function, and icons the `__icon()` function.

* Respect language punctuation rules (unbreakable spaces before some french punctuation marks and between number decimals, "" in english vs « » in french, etc.).

* QA test everything: in both languages, in both dark and light mode, with all user access rights (guest, user, mod, admin).

* Any changes in `actions` or `inc` should come with a corresponding update to `test`, run the test suite locally (`tests.php` at the project's root).

If you mess up the coding style, if you're not biligual and can't do translations, if you're afraid you'd do anything wrong: don't worry, it will be reworked by someone else before it is merged. We are aware that it's never easy and can even be quite uncomfortable to imitate someone else's coding style when no linter is provided. The simple act of contributing is appreciated on its own.