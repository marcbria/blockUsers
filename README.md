Block Users (WORK IN PROGRESS)
===========

For OJS/OMP 3.3.0

The plugin allows to upload a file with a list of mails of users to be disabled.

It's usefull to block mailings and logins in journals that have a lot of spam users.
Once disabled, after a certain time, if nobody complains, users could be merged/removed.

Usage
=====

Copy the plugin folder to plugins/generic/ and enable it. 
Click on "Upload list of mails" to upload a new file.
Plugin will compare the list with the users of the existing journal and disable the user if there is a match.


TODO (and ideas)
================

- [ ] Restrict permisions to JournalManager.
- [ ] Show some basic info about the list of mails and ask for confirmation before disable.
- [ ] Revert the logic to "enable" instead of "disable".
- [ ] Log the usage of the plugin.
- [ ] Let it run for all the journals of an installation.

***
Plugin created by Universitat Autònoma de Barcelona (https://publicacions.uab.cat).
***
