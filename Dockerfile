FROM ubuntu:18.04

ARG DEBIAN_FRONTEND="noninteractive"

RUN apt update
RUN apt install -y apache2
RUN apt install -y php
COPY ./www* /var/www/html/.
COPY ./src /var/www/src

CMD ["apachectl", "-D", "FOREGROUND"]
