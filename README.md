Block Users (WORK IN PROGRESS)
===========

For OJS/OMP 3.3.0

The plugin reads a file with a list of mails of users to be disabled.

It was created to block mailings and logins in journals that have a lot of spam users.
Once disabled (after a certain time, if nobody complains) users could be merged/removed.

This is a CLI plugin (no web GUI), so it need to be called from the command-line as follows:

```
$ php tools/importExport.php BlockUsersPlugin usage
```

Usage
=====

1. Copy the plugin folder to plugins/importexport/ and enable it. 
2. Upload your list of users to be blocked.
3. Run the script as follows: 
```
$ php tools/importExport.php BlockUsersPlugin path/to/users2block.lst
```

Plugin will compare the list with the users of the existing journal and disable the user if there is a match.


TODO (and ideas)
================

- [ ] Show some basic info about the list of mails and ask for confirmation before disable.
- [ ] Revert the logic to "enable" instead of "disable".
- [ ] Let it run for specific journals of an installation.
- [ ] Log the usage of the plugin.
- [ ] Implement a web frontend.
- [ ] Restrict permisions to JournalManager.

***
Plugin created by Universitat Autònoma de Barcelona (https://publicacions.uab.cat).
***
