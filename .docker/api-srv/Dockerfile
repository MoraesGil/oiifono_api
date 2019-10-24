FROM wyveo/nginx-php-fpm:latest
WORKDIR /usr/share/nginx/
RUN apt-get update
RUN rm -rf /usr/share/nginx/html
RUN mkdir html/
RUN ln -s public html
RUN mkdir storage/
RUN chmod -R 777 storage/