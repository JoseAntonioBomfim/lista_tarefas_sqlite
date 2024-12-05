# Usar uma imagem base com PHP e Apache
FROM php:8.1-apache

#Setup de uma aplicação simplesna porta 80 que precisa do sqlite, cujo arquivo do banco de dados está na raiz do projeto lista_tarefas.
COPY . /var/www/html/
RUN apt-get update && apt-get install -y aqlite3 libsqlite3-dev
RUN docker-php-ext-install pdo pdo_sqlite
RUN chown -R www-data:www-data /var/www/html/
RUN chown -R 755 /var/www/html/

# Expor a porta 80
EXPOSE 80