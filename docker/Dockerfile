FROM php:7.4-apache

RUN pecl install xdebug > /dev/null && \
	docker-php-ext-enable xdebug > /dev/null && \
	sed -i "s/zend_extension/;zend_extension/g" `php --ini | grep xdebug | sed 's/,$//'`