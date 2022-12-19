FROM php:7.4-cli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . .

RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

RUN composer install --no-dev

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-d", "post_max_size=50M", "-d", "upload_max_filesize=50M", "-d", "max_execution_time=1200"]
