#!/bin/bash

# Install Plugins
wp plugin install \
	/var/www/html/wp-config/plugins/all-in-one-wp-migration.7.79.zip \
	/var/www/html/wp-config/plugins/all-in-one-wp-migration-unlimited-extension-2.54.zip \
	--activate --allow-root

# Change plugin permissions
# try getting uid from docker, if it fails, try 33 (should work)
chown -Rf www-data:www-data /var/www/html/wp-content/
