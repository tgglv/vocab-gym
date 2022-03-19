FROM php:7.4-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN pecl install xdebug > /dev/null && \
	docker-php-ext-enable xdebug > /dev/null && \
	sed -i "s/zend_extension/;zend_extension/g" `php --ini | grep xdebug | sed 's/,$//'`

RUN a2enmod rewrite && \
	service apache2 restart