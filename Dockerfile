FROM ubuntu:18.04

ARG DEBIAN_FRONTEND="noninteractive"

RUN apt update
RUN apt install -y apache2
RUN apt install -y php
RUN rm /var/www/html/*

CMD ["apachectl", "-D", "FOREGROUND"]
