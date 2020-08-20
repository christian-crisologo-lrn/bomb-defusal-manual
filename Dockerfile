FROM ubuntu:18.04

ARG DEBIAN_FRONTEND="noninteractive"

RUN apt update
RUN apt install -y apache2
RUN apt install -y php
RUN rm /var/www/html/*
COPY ./www* /var/www/html/.
RUN mv /var/www/html/assessment.php /var/www/html/index.php
COPY ./src /var/www/src

CMD ["apachectl", "-D", "FOREGROUND"]
