FROM php:8.3-apache

# Install the PHP extensions the app relies on (pdo_mysql pulls in pdo,
# mbstring is used for correct multibyte length validation of task text).
# libonig-dev provides oniguruma, which mbstring is built against.
RUN apt-get update \
    && apt-get install -y --no-install-recommends libonig-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_mysql mbstring

RUN printf 'display_errors = Off\nlog_errors = On\nexpose_php = Off\n' \
    > /usr/local/etc/php/conf.d/zz-security.ini

# Explicit, sensible OPcache tuning for a small app (speed).
RUN { \
      echo 'opcache.enable=1'; \
      echo 'opcache.enable_cli=0'; \
      echo 'opcache.memory_consumption=64'; \
      echo 'opcache.max_accelerated_files=10000'; \
      echo 'opcache.interned_strings_buffer=8'; \
      echo 'opcache.validate_timestamps=1'; \
      echo 'opcache.revalidate_freq=2'; \
    } > /usr/local/etc/php/conf.d/opcache.ini
