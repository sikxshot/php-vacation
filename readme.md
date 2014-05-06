[PHP Vacation] [https://github.com/james-m9/php-vacation] - PHP Web interface for the Unix/Linux vacation package
PHP Vacation is a web interface for the vacation command line application found on Linux and Unix systems.
I decided to write this small app so that my customers could manage their "out
of office messages" without having to rely on a Linux admin. 

# About
After a fair amount of Googling, I found only one other 'standalone' web app that offered a web interface to the vacation package. It was written in PHP but used MySQL and was built using Dreamweaver so it didn't quite suit my needs. It did however give me a direction and so I must thank the developer, 'damiaan'. (http://sourceforge.net/projects/vacation-web/)

The name, php-vacation, is a bit of a misnomer as jQuery plays a greater roll in the program logic than PHP does. 

## Apologies

As any moderately proficient developer will notice, php-vacation has not been
developed by a qualified programmer, just an enthusiastic hacker :) 

Comments and suggestions are welcomed and appreciated!

## Technical and Feature Overview
* Code: PHP (5.3.x), jQuery (jquery-1.10.2), XML
* My first serious attempt at using PHP classes (lots more to-do). Thanks Lynda.com & Kevin Skoglund, "PHP with MySQL - Beyond The Basics"
* User authentication IMAP(s)/POP3(s) php5-imap
* Vacation message CRUD, jQuery (ajax & PHP)
* Once logged in, php-vacation creates the the following files (~/.vacation.db ~/.vacation.msg ~/.forward ~/.vacation.d/default.xml)
* It always sets user and group permissions to allow the web user to make changes. In order to do this, php-vacation needs to run a script as root. This is managed through sudo (see Installation section).
* Messages are stored in XML in ~/.vacation.d/default.xml, all CRUD is   performed on this file. I am conidering using a central XML file to reduce the 'polution' of user's file system but am I concerned that this will slow the system down on larger installations, plus add issues with file locking etc, more reading to do here.
* When the user (de)activates their vacation message, php-vacation rewrites   the ~/.forward file and calls "/usr/bin/vacation -i" which inilizes the vacation database file.


## To-do
- Require user confirmation when creating files in their home directory.
- Add and improve error handling (mostly missing)
- Improve XML_Parser class
- Refactor 
- Add form validation
- Add facility for multiple message templates
- Add support for aliases
- Add support for additional forward rules
- Tidy up messages
- Centralise XLM database
- Create multiple message templates (to-do code structure done - need to 
  complete CRUD)

# Installation & system requirements
This package assumes you have a working mail server, with an IMAP (preferably)
or POP3 server that is working and delivering mail correctly.

Test that you can auth with "plain text" - although the php-imap module 
supports ssl auth I've yet to test and enable it.

For more information check out the Dovecot Wiki on how to test auth. If you use
a different POP3 or IMAP server, use your own server docs for config 
information

http://wiki2.dovecot.org/TestInstallation
http://wiki2.dovecot.org/TestPop3Installation

## Ubuntu
Install lamp-server
	$ sudo apt-get install lamp-server^

Install the IMAP module for php5
	$ apt-get install php5-imap


## Centos

## Vacation History and Author(s) - from the vacation man page
The vacation command appeared in 4.3BSD. 
vacation was developed by Eric Allman and the University of California, 
Berkeley in 1983. The Linux version of vacation is maintained by 
Marco d'Itri <md@linux.it> and contains code taken from the three free BSD and 
some patches applied to a linux port.
