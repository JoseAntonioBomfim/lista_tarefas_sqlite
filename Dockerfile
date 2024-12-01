# Usar uma imagem base com PHP e Apache
FROM php:8.1-apache

# Instalar as dependências necessárias
RUN docker-php-ext-install pdo pdo_sqlite

# Ativar mod_rewrite (útil se você precisar de URLs amigáveis)
RUN a2enmod rewrite

# Copiar os arquivos do projeto para o diretório apropriado
COPY . /var/www/html/

# Definir as permissões corretas para o diretório
RUN chown -R www-data:www-data /var/www/html/

# Expor a porta 80
EXPOSE 80