<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre el proyecto

La aplicación se encuentra construida con Laravel 9.11 y PHP 8.0.2.

## Ejecución

La base de datos fue compartida por lo que no será necesario correr comandos de artisan adicionales, el nombre de la base de datos junto con el usuario y la contraseña de localhost pueden configurarse en el ``.env`` de la aplicación. Ejemplo;

``DB_DATABASE=konecta_coffee
DB_USERNAME=root
DB_PASSWORD=``

Una vez configurado el ``.env`` solo necesitaremos ejecutar ``php artisan serve`` y ``npm run dev`` (cada comando en una terminal diferente para no cortar la ejecución del proceso) 

## Iniciar aplicación

Al iniciar el proyecto (http://localhost:8000 por defecto) nos mandará al login, los accesos son los siguientes: 
   
   ``email: santiago.echeverri@grupokonecta.com password: 123456``
    
También es posible registrarnos en la aplicación. 
