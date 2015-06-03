#!/usr/bin/env bash

abspath=$(cd "$(dirname "$0")"; pwd)
vagrantkey=${abspath}/.vagrant/machines/default/virtualbox/private_key

ssh vagrant@filesharer.vagrant -i ${vagrantkey} "cd /vagrant; /vagrant/vendor/bin/phpunit $@;"
