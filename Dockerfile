FROM php:8.2-apache

# Habilita o módulo mod_rewrite do Apache para rotas MVC
RUN a2enmod rewrite

# Instala extensões PDO MySQL para o PHP
RUN docker-php-ext-install pdo pdo_mysql

# Copia os arquivos do projeto para o diretório web do Apache
COPY . /var/www/html/

# Define a pasta public como raiz da aplicação (se o seu index.php estiver dentro de public)
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
