FROM alpine:3.16

RUN apk add \
	# minimal to run
	nginx \
	php \
	php-fpm \
	php-opcache \
	\
	# migration
	php-mysqli \
	php-ctype \
	\
	# session
	php-session \
	\
	# composer
	curl \
	php-phar \
	php-iconv \
	php-curl \
	\
	# phpdotenv package \
	php-mbstring \
	\
	# development
	nano

# NGINX
######################################################################
# Setup NGINX App config
COPY docker/nginx.app.conf /etc/nginx/http.d/default.conf


# PHP
######################################################################
# Create symlink so programs depending on `php` still function
RUN ln -s /usr/sbin/php-fpm8 /usr/sbin/php-fpm

# Configure PHP-FPM
COPY docker/fpm-pool.conf /etc/php8/php-fpm.d/www.conf



# Fix Permission (support volume)
RUN adduser -S www-data -u 1000
RUN sed -i "s/user = nobody/user = www-data/g" /etc/php8/php-fpm.d/www.conf
RUN sed -i "s/group = nobody/group = www-data/g" /etc/php8/php-fpm.d/www.conf


# Project Files
######################################################################
# Change Dir
WORKDIR /app

# Install Composer and dependency
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#COPY composer.json composer.lock ./
#RUN composer install --working-dir=. --prefer-dist --no-scripts --no-dev && rm -rf /root/.composer

# ADD Project to Image
COPY . .


# Expose the port nginx is reachable on
EXPOSE 80

# start nginx & php-fpm
COPY docker/start.sh /
CMD sh /start.sh

# Configure a healthcheck to validate that everything is up & running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:80/fpm-ping