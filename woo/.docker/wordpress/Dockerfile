ARG WORDPRESS_VERSION

FROM wordpress:${WORDPRESS_VERSION}

WORKDIR /var/www/html

COPY /plugins /var/www/html/wp-config/plugins
COPY /scripts /var/www/html/wp-config/scripts
COPY php_custom.ini /usr/local/etc/php/conf.d/
COPY wp-cli.phar /usr/local/bin/wp

RUN apt-get update && apt-get install -y \
    curl

RUN chmod +x /usr/local/bin/wp
RUN wp --info

