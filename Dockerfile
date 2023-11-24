FROM php:7.2-apache
LABEL author="Siggi Bjarnason <siggi@infosechelp.net>"
RUN docker-php-ext-install pdo pdo_mysql mysqli
