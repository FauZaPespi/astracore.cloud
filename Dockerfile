FROM php:8.4-apache
COPY ./httpd-vhost.conf /etc/apache/sites_available/
WORKDIR /var/www/html
RUN apt-get update 
RUN apt-get install -y libfreetype6-dev
RUN apt-get install -y libjpeg62-turbo-dev 
RUN apt-get install -y libpng-dev 
RUN apt-get install -y curl 
RUN docker-php-ext-configure gd --with-freetype --with-jpeg 
RUN docker-php-ext-install -j$(nproc) gd 
RUN docker-php-ext-install pdo_mysql 
RUN a2enmod rewrite 
# RUN sed -i '/LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf 
# RUN sed -i 's#AllowOverride [Nn]one#AllowOverride All#' /usr/local/apache2/conf/httpd.conf
RUN service apache2 restart