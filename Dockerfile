FROM php:7.3

WORKDIR /code

COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN alias composer='php /usr/bin/composer'

RUN composer install
