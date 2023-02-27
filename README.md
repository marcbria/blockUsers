Block Users
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
$ php tools/importExport.php BlockUsersPlugin [action] [path/to/filename.lst]
```

Possible actions are:
- usage: how to call the script.
- disable: block users whose mail is on the file.
- enable: unblock the users whose mail is on the file.


TODO (and ideas)
================

- [ ] Move from importExport to PKP\cliTool\CommandLineTool
- [x] Show some basic info about the list of mails.
- [ ] "Ask for confirmation" mode before disable.
- [x] Revert the logic to "enable" instead of "disable".
- [ ] Let it run for specific journals of an installation.
- [ ] Log the usage of the plugin.
- [ ] Implement a web frontend.
- [ ] Restrict permisions to JournalManager.

***
Plugin created by Universitat Autònoma de Barcelona (https://publicacions.uab.cat).
***
