FROM php:7.1-apache

# install the PHP extensions we need (https://make.wordpress.org/hosting/handbook/handbook/server-environment/#php-extensions)
RUN set -ex; \
        \
        savedAptMark="$(apt-mark showmanual)"; \
        \
        apt-get update; \
        apt-get install -y --no-install-recommends \
                libjpeg-dev \
                libmagickwand-dev \
                libpng-dev \
        ; \
        \
        docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr; \
        docker-php-ext-install -j "$(nproc)" \
                bcmath \
                exif \
                gd \
                mysqli \
                opcache \
                zip \
        ; \
        pecl install imagick-3.4.4; \
        docker-php-ext-enable imagick; \
        \
# reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies
        apt-mark auto '.*' > /dev/null; \
        apt-mark manual $savedAptMark; \
        ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
                | awk '/=>/ { print $3 }' \
                | sort -u \
                | xargs -r dpkg-query -S \
                | cut -d: -f1 \
                | sort -u \
                | xargs -rt apt-mark manual; \
        \
        apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
        rm -rf /var/lib/apt/lists/*

# set recommended PHP.ini settings
# see https://secure.php.net/manual/en/opcache.installation.php
RUN { \
                echo 'opcache.memory_consumption=128'; \
                echo 'opcache.interned_strings_buffer=8'; \
                echo 'opcache.max_accelerated_files=4000'; \
                echo 'opcache.revalidate_freq=2'; \
                echo 'opcache.fast_shutdown=1'; \
         } > /usr/local/etc/php/conf.d/opcache-recommended.ini
# https://codex.wordpress.org/Editing_wp-config.php#Configure_Error_Logging
RUN { \
                echo 'error_reporting = 4339'; \
                echo 'display_errors = Off'; \
                echo 'display_startup_errors = Off'; \
                echo 'log_errors = On'; \
                echo 'error_log = /dev/stderr'; \
                echo 'log_errors_max_len = 1024'; \
                echo 'ignore_repeated_errors = On'; \
                echo 'ignore_repeated_source = Off'; \
                echo 'html_errors = Off'; \
         } > /usr/local/etc/php/conf.d/error-logging.ini

RUN a2enmod rewrite expires


VOLUME ./wp-content:/var/www/html/wp-content

ENV WORDPRESS_DB_HOST: db:3306
ENV WORDPRESS_DB_PASSWORD: root
ENV WORDPRESS_VERSION 5.2.2
ENV WORDPRESS_SHA1 3605bcbe9ea48d714efa59b0eb2d251657e7d5b0

RUN set -ex; \
        curl -o wordpress.tar.gz -fSL "https://wordpress.org/wordpress-${WORDPRESS_VERSION}.tar.gz"; \
        echo "$WORDPRESS_SHA1 *wordpress.tar.gz" | sha1sum -c -; \
# upstream tarballs include ./wordpress/ so this gives us /usr/src/wordpress
        tar -xzf wordpress.tar.gz -C /usr/src/; \
        rm wordpress.tar.gz; \
        chown -R www-data:www-data /usr/src/wordpress

COPY docker-entrypoint.sh /usr/local/bin/
RUN ["chmod", "+x", "/usr/local/bin/docker-entrypoint.sh"]

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
