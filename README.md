CNCPS
===================

## Paquetes/Librerías Requeridos

##### MySQL
    # apt-get install mysql-server
##### Apache2 
    $ apt-get install apache2 
##### PHP5
    $ apt-get install php5 php5-mysql libapache2-mod-php5
##### phpMyAdmin
    $ apt-get install phpmyadmin
    $ echo "Include /etc/phpmyadmin/apache.conf" | sudo tee -a /etc/apache2/apache2.conf > /dev/null
    $ service apache2 restart
    # En el navegador: http://<SERVERIP>/phpmyadmin/ #
##### Symfony
    $ sudo mkdir -p /usr/local/bin
    $ sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
    $ sudo chmod a+x /usr/local/bin/symfony
    # Ejecución #
    $ symfony new cncps
    $ cd cncps/
    $ php bin/console server:[start|stop] [ip:puerto] (Por defecto en http://127.0.0.1:8000)
##### Composer
 * Seguir las instrucciones detalladas en: [Get Composer](https://getcomposer.org/download/)
 * Se recomienda crear un directorio en la raíz del proyecto

##### Twig & Bootstrap
    # En el directorio raíz del proyecto ejecutar: #
    $ composer/composer.phar require twig/twig:~1.0
    $ composer/composer.phar require twbs/bootstrap

#### Otros:
 * Crear Base de Datos ```$ mysqladmin -u root -p create indicadores_ods```
 * Importar Esquema de la Base de Datos:  ```$ mysql -u root -p indicadores_ods < indicadores_ods.sql```



#### Otra config necesaria:
 * Doctrine - en app/config/config.yml

        mapping_types:
            enum:   string
            bit:    string


    Luego,
        php app/console doctrine:mapping:import --force AppBundle xml
        
        php app/console doctrine:generate:entities AppBundle

        php app/console generate:doctrine:crud --entity=AppBundle:Objetivos --with-write

        