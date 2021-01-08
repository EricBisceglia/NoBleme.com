Contributing to NoBleme.com
===

Contributors are welcome to contribute to NoBleme's source code, be it for a tiny bug fix, a refactor, or a new feature.

All contributions should be done by creating a branch of your own from `develop`, then opening a merge request on the `develop` branch.

If your contribution is related to a task on [NoBleme's to-do list](https://nobleme.com/todo_link), include the task's ID in your branch name, and include the task's ID and task's description in your pull request message.

Before doing any contribution, especially if it is a new feature, it might save you a lot of time to discuss it beforehand with Bad on the #dev channel of [NoBleme's IRC server](https://nobleme.com/todo_link).

 

Monolingual contributors
===

NoBleme is meant to work in both french and english, but it can obviously not be expected of everyone to master both languages when contributing.

If you want to provide a new feature, feel free to leave all the french translations empty. They will be filled in by someone else who knows french.

 

Coding style and guidelines
===

There is currently no written style guide for this project's source code. Instead, I will have to ask you to look at how things are currently done, and to do your best to imitate this style in your contributions. It can be summarized as such:

* 120 characters long lines (119 characters per line max)

* Indentation levels of 2 spaces

* Brackets on their own lines, indented to the level of their parent

* Fully procedural code - no objects, jumps, or callbacks unless strictly necessary

* Lots of comments explaining the thought process of every piece of code

* A line jump before every comment

* Big comment blocks separating the sections of source code files

* 4 empty lines before every big comment block

* Use `sanitize()` on everything before using it in MySQL queries

* Use `query()` to run your MySQL queries

* Vertical indentation of MySQL queries for optimal readability

* Use website-provided functions over PHP stdlib functions whenever possible

* Split the logic in `actions`, the views in `pages`, and the translations in `lang`

* All of the codebase (comments, variable names, etc.) should be in english

* All text displayed in pages should be declared as `lang` translations and be called through the `__()` function

* All links should use the `__link()` function, and icons the `__icon()` function

* Respect language punctuation rules (unbreakable space before some french punctuation marks and between number decimals, "" in english vs « » in french, etc.)

* Do a bit of QA testing before submitting your merge request!

If you mess up the coding style, if you're not biligual and can't do translations, if you're afraid you'd do anything wrong: don't worry, it will be reworked before it is merged. It's never easy and definitely not comfortable to imitate someone else's coding style when no linter is provided, so there are no expectations of perfectly respected coding style. The simple act of contributing is nice enough that it is appreciated on its own.