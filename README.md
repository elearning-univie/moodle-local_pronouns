Pronouns
==========================

This file is part of the local_pronouns plugin for Moodle - <http://moodle.org/>

*Author:* Adrian Czermak, Angela Baier, Thomas Wedekind

*Copyright:* 2026 [University of Vienna](https://www.univie.ac.at/)

*License:* [GNU GPL v3 or later](http://www.gnu.org/copyleft/gpl.html)


Description
-----------

The local_pronouns plugin allows users to select their preferred pronouns in their Moodle profile to reflect the diversity of gender identities.
This enhances an inclusive teaching and learning environment.


Usage
-----

A student would like to display their preferred pronoun to other students and teachers, so that they can be address the person in the desired way.


How the plugin works?
------------------------------

* Users can select a value from a dropdown menu with predefined values in a manual profile field called "Pronouns" on their personal profile.
* When the changes are saved, the value is stored in the user profile field "Alternate name" (alternatename), located in the user table.
* The value can be changed later or removed (by selecting "-") at any time.

* To ensure that the pronoun is shown to other users in various places (e.g., the participant list, course grades or the profile), the field "alternatename" must be added via the Site administration (Users/ Permissions/ Users policies) in the settings for "Full name format" and/ or "Alternative full name format"


Installation
------------

* Copy the module code directly to the *moodleroot/local/pronouns* directory.

* Log into Moodle as administrator.

* Open the administration area (*http://your-moodle-site/admin*) to start the installation
  automatically.


Admin Settings & Configuration
--------------
* The plugin itself does not have any settings of its own.
* The list of available pronouns can be customized directly in the manual profile field "Pronouns" and the profile field"s category via the Site administration (Users/ Accounts/ User profile fields).

[Detailed information on the recommended configuration]([url](https://github.com/elearning-univie/moodle-local_pronouns/wiki))


Privacy API
-----------

The plugin fully implements the Moodle Privacy API.


Bug Reports / Support
---------------------

We try our best to deliver bug-free plugins, but we can not test the plugin for every platform,
database, PHP and Moodle version. If you find any bug please report it on
[GitHub](https://github.com/elearning-univie/moodle-local_pronouns/issues/). Please
provide a detailed bug description, including the plugin and Moodle version and, if applicable, a
screenshot.

You may also file a request for enhancement on GitHub. If we consider the request generally useful
and if it can be implemented with reasonable effort we might implement it in a future version.

You may also post general questions on the plugin on GitHub, but note that we do not have the
resources to provide detailed support.


License
-------

This plugin is free software: you can redistribute it and/or modify it under the terms of the GNU
General Public License as published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

The plugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
General Public License for more details.

You should have received a copy of the GNU General Public License with Moodle. If not, see
<http://www.gnu.org/licenses/>.
