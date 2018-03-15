#!/bin/bash

echo "XDEBUG"
docker-compose exec  --user filegen container_filegen bash -c 'export XDEBUG_CONFIG="remote_host=192.168.0.15 idekey=PHPSTORM"'
docker-compose exec  --user filegen container_filegen bash -c 'export PHP_IDE_CONFIG="serverName=192.168.0.26"'

echo "SUPRESSION VENDOR CACHE COMPOSER.LOCK"
docker-compose exec --user filegen container_filegen bash -c 'php -v'
docker-compose exec --user filegen container_filegen bash -c 'rm -rf /var/www/html/filegen/composer.lock'
docker-compose exec --user filegen container_filegen bash -c 'rm -rf /var/www/html/filegen/vendor'
docker-compose exec --user filegen container_filegen bash -c 'rm -rf /var/www/html/filegen/var/cache'
docker-compose exec --user filegen container_filegen bash -c 'rm -rf /var/www/html/filegen/var/logs'
docker-compose exec --user filegen container_filegen bash -c 'rm -rf /var/www/html/filegen/var/sessions'

echo "COMPOSER INSTALL"
docker-compose exec  --user filegen container_filegen bash -c '/usr/local/bin/composer install'


exit 0
