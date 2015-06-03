#!/usr/bin/env bash

# TODO: maybe check directories, start/stop services, etc.

echo '                                                                       ';
echo '                                                                       ';
echo ' #######                  #####                                        ';
echo ' #       # #      ###### #     # #    #   ##   #####  ###### #####     ';
echo ' #       # #      #      #       #    #  #  #  #    # #      #    #    ';
echo ' #####   # #      #####   #####  ###### #    # #    # #####  #    #    ';
echo ' #       # #      #            # #    # ###### #####  #      #####     ';
echo ' #       # #      #      #     # #    # #    # #   #  #      #   #     ';
echo ' #       # ###### ######  #####  #    # #    # #    # ###### #    #    ';
echo '                                                                       ';
echo '                                                                       ';
echo '                                                                       ';
echo '>> bootstrap.sh'
echo '                                                                       ';
echo '                                                                       ';

# check if vm hostname already exists in hosts file
vm_hostname="filesharer.vagrant"
vm_ip="192.168.66.66"
if [ -r /etc/hosts ]; then
	set +e
	fgrep "${vm_hostname}" /etc/hosts 2>&1 > /dev/null
	if [ $? -ne 0 ]; then
		echo "------------------"
		echo "HINT: please add hostname entry ${vm_hostname} for ip address ${vm_ip} in /etc/hosts:"
		echo "${vm_ip}	${vm_hostname}"
		echo "------------------"
	fi
	set -e
fi

# startup apache
sudo /etc/init.d/apache2 restart
