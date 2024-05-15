FROM php:8.2.9-fpm

RUN apt-get update --quiet && \
    apt-get upgrade --quiet --yes && \
    rm -rf /var/lib/apt/lists/*

# Set application directory
RUN rm -r /var/www/html && \
    mkdir /var/www/app

WORKDIR /var/www/app

# Use php.ini for development
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Add some convenience aliases
RUN echo "alias ll='ls -al --color'" | tee -a /root/.bashrc
RUN echo "alias unit='./vendor/bin/phpunit'" | tee -a /root/.bashrc
RUN echo "alias stan='./vendor/bin/phpstan'" | tee -a /root/.bashrc
RUN echo "alias bc='php bin/console'" | tee -a /root/.bashrc

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN apt-get update --quiet && \
    apt-get install --quiet --yes curl \
                                  unzip \
                                  libzip4 \
                                  git \
                                  libzip-dev && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install -j$(nproc) zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony requirements
RUN apt-get update --quiet && \
    apt-get install --quiet --yes libicu-dev && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install -j$(nproc) intl \
                                      opcache

# Install symfony installer
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony && \
    rm -rf /root/.symfony5
