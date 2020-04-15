# apiRestSample
Api rest con PHP utilizando Slim v4

# Requisitos PHP
1. Composer
2. Slim
3. slim psr7
4. php-di
5. PDO

# Software
1. MAMP (apache, mysql, phpmyadmin)
2. Visual Studio Code (con terminal incluido)
3. Navicat (opcional)

# Configuración
1. Instalar MAMP.
2. Instalamos nuestro editor de código favorito.
3. Nos aseguramos de contar con los plugin necesarios en nuestro editor de código.
4. Creamos un virtual host en httpd-vhosts.conf: /Applications/MAMP/conf/apache/extra
5. Tenemos que registrar la dirección del virtual host: sudo pico /etc/hosts
6. Iniciamos MAMP.
7. Abrirá una web donde podremos acceder al phpmyadmin para crear nuestra base de datos.
8. Creamos una base de datos MySql.
9. Creamos el api rest con PDO para comunicarnos con la base de datos.
10. Probamos con postman los endpoints( GET, POST, PUT, DELETE)
