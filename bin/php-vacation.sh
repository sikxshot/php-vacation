#!/bin/bash - 
#===============================================================================
#
#          FILE: /usr/local/share/vacation/bin/php-vacation.sh
# 
#         USAGE: called by php ./php-vacation.sh path/username ( sudo php-vacation.sh /home/james james)
# 
#   DESCRIPTION: A wrapper to create the files requred for the vacation package via 
#		         the web interface.
#		         Files: .forward .vacation.msg .php-vacation.d/
# 
#       OPTIONS: $1 = /home/dir, $2 = username
#  REQUIREMENTS: /etc/sudoers.d/php-vacation 
#  				 (www-data  ALL=(ALL) NOPASSWD:/usr/local/share/vacation/bin/php-vacation.sh)
#          BUGS: ---
#         NOTES: I want to change this script to abstract the commands
#        AUTHOR: James Melliar (james@newwave.co.za)
#  ORGANIZATION: Newwave
#       CREATED: 18/02/2014 13:16:28 SAST
#      REVISION:  0.1
#===============================================================================

set -o nounset # Treat unset variables as an error

path=$1;
user=$2;

if [ -d $path ] ; then
	# create files - if they don't exist else echo message
	[ ! -f ${path}/.forward ] && /usr/bin/touch ${path}/.forward || echo "${path}/.forward exists, skipping." ;
	[ ! -f ${path}/.vacation.msg ] && /usr/bin/touch ${path}/.vacation.msg || echo "${path}/.vacation.msg exists, skipping." ;
	[ ! -d ${path}/.php-vacation.d ] && /bin/mkdir ${path}/.php-vacation.d ||  echo "${path}/.php-vacation.d exists, skipping." ;
	#[ ! -f ${path}/.php-vacation.d/default.msg ] && /usr/bin/touch ${path}/.php-vacation.d/messages.xml || echo "${path}/.php-vacation.d/messages.xml exists, skipping." ;

	# set ownership, even if files exist
	/bin/chown ${user}:www-data ${path}/.forward
	/bin/chown ${user}:www-data ${path}/.vacation.msg
	/bin/chown -R ${user}:www-data ${path}/.php-vacation.d
	#/bin/chown -R www-data:www-data ${path}/.php-vacation.d/messages.xml # messages.xml owned by www-data to user can't del default message

	# set permissions, even if files exist
	/bin/chmod 660 ${path}/.forward
	/bin/chmod 660 ${path}/.vacation.msg
	/bin/chmod 770 ${path}/.php-vacation.d
	#/bin/chmod 660 ${path}/.php-vacation.d/messages.xml
	echo "Permissions and ownership set; success!!"
else
	echo "Fatal error!!! The directory ${path}${user} does not exist..";
fi



