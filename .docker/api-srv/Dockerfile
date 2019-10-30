FROM wyveo/nginx-php-fpm:php71

#tools install
RUN apt-get update
RUN apt-get install -y git tmux vim curl wget zip unzip htop
RUN apt-get update
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

#setup my workspace
WORKDIR /var/
RUN mkdir -p www/myapp
RUN mkdir storage/
RUN mkdir bootstrap/
RUN chmod -R 777 storage/
RUN chown -R www-data: storage bootstrap
COPY default.conf /etc/nginx/conf.d/
WORKDIR /var/www/myapp
