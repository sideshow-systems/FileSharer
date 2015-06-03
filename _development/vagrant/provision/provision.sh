#!/bin/bash

PROVISIONED_ON=/etc/vm_provision_on_timestamp
if [ -f "${PROVISIONED_ON}" ]
then
	echo "=========================================================================="
	echo ""
	echo "VM was already provisioned at: $(cat ${PROVISIONED_ON})"
	echo "To run system updates manually login via 'vagrant ssh' and run 'apt-get update && apt-get upgrade' or to boot up a clean vagrant vm using 'qvagrant destroy -f; qvagrant up'"
	echo ""
	echo "=========================================================================="
	echo ""
	exit
fi

# load custom files
#incbasepath="/vagrant/_development/vagrant/provision/includes"
#if [ -f "${incbasepath}/aptproxy.sh" ]; then
#	source "${incbasepath}/aptproxy.sh"
#fi
echo 'Acquire::http::Proxy "http://creanas:9999";' > /etc/apt/apt.conf.d/01proxy


# perform base installation
echo "" > /etc/apt/sources.list

# this would use the specific server ftp.de.debian.org
#echo "deb http://ftp.de.debian.org/debian/ wheezy main" >> /etc/apt/sources.list
#echo "deb-src http://ftp.de.debian.org/debian/ wheezy main" >> /etc/apt/sources.list

# use debian mirror selector
echo "deb http://http.debian.net/debian wheezy main" >> /etc/apt/sources.list
echo "deb-src http://http.debian.net/debian wheezy main" >> /etc/apt/sources.list

echo "deb http://security.debian.org wheezy/updates main" >> /etc/apt/sources.list

apt-get update
apt-get -y upgrade

apt-get install -y pv

apt-get -y purge vim-tiny
apt-get install -y vim git-core 
apt-get -y purge nano

# vim config
cat <<EOF > /home/vagrant/.vimrc
set nocompatible
let s:cpo_save=&cpo
set cpo&vim
map! <xHome> <Home>
map! <xEnd> <End>
map! <S-xF4> <S-F4>
map! <S-xF3> <S-F3>
map! <S-xF2> <S-F2>
map! <S-xF1> <S-F1>
map! <xF4> <F4>
map! <xF3> <F3>
map! <xF2> <F2>
map! <xF1> <F1>
map <xHome> <Home>
map <xEnd> <End>
map <S-xF4> <S-F4>
map <S-xF3> <S-F3>
map <S-xF2> <S-F2>
map <S-xF1> <S-F1>
map <xF4> <F4>
map <xF3> <F3>
map <xF2> <F2>
map <xF1> <F1>
let &cpo=s:cpo_save
unlet s:cpo_save
set backspace=2
set bg=dark
syntax on
set nobackup
set nu
set hls
EOF


# Prepare Apache/PHP projects
apt-get install -y apache2 php5 libapache2-mod-php5 php5-gd php5-curl

VHOST=$(cat <<EOF
<VirtualHost *:80>
  DocumentRoot "/vagrant"
  ServerName localhost
  <Directory "/vagrant">
    AllowOverride All
  </Directory>
  CustomLog /vagrant/logs/apache_access_log.log common
  ErrorLog /vagrant/logs/apache_error_log.log
</VirtualHost>
EOF
)
echo "${VHOST}" > /etc/apache2/sites-enabled/000-default

# enable mod rewrite
a2enmod rewrite

# bugfix for VirtualBox folder sync, otherwise use nfs foldersharing in vagrantfile
# http://docs.vagrantup.com/v2/synced-folders/virtualbox.html
echo 'EnableSendfile Off' >> /etc/apache2/apache2.conf

# restart apache
/etc/init.d/apache2 restart



#setup logrotate
sudo apt-get install -y logrotate
mkdir -p /home/vagrant/logrotate
cp /vagrant/logs/logrotate.conf /home/vagrant/logrotate/logrotate.conf
sudo chown root /home/vagrant/logrotate/logrotate.conf

# setup cronjobs
mkdir -p /home/vagrant/cronjobs
cp /vagrant/_development/vagrant/cronjobs/* /home/vagrant/cronjobs/
cd /home/vagrant/cronjobs/
chmod 755 *.sh
cat crontab | crontab -; crontab -l

# install phpunit via composer
sudo curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo mkdir /vagrant/vendor
chmod 777 /vagrant/vendor
cd /vagrant
sudo COMPOSER=/vagrant/composer.json composer install
echo 'PATH="$HOME/bin:/vagrant/vendor/bin:$PATH"' >> ~/.profile

echo "alias ll='ls -la'" >> /home/vagrant/.profile

# clear package cache
apt-get clean

# Tag the provision time (01_provisioncheck.sh):
date > "${PROVISIONED_ON}"
