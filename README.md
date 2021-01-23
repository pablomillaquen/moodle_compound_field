# README #

Este repo consiste en 2 plugins creados para Moodle, usados para registro de usuarios.
El problema que se desea resolver es, cuando un usuario requiere registrar una lista de campos múltiples, por ejemplo: 	
	Capacitaciones externas a Moodle que haya realizado:
	* Capacitación 1
	* Capacitación 2
	* ... 
![picture]https://bitbucket.org/educadores-tradicionales-ciae/datos-compuestos-registro/src/master/ejemplos/ejemplo%20plugin.png

### OBJETIVOS ###

* Version 1.0

El repositorio actual posee 2 plugins:
* COMPOUND: Permite crear un tipo de campo personalizado, con filas de campos. Utiliza una librería Javascript para crear este listado (https://github.com/json-editor/json-editor), por lo que debe cumplir con las pautas de dicha librería para crear el formulario.
Crea los campos personalizados en la tabla "mdl_user_info_field".


* JSONFORM: Este plugin crea el formulario, lo presenta en pantalla y guarda los datos usando AJAX. Al instalarlo, crea registros en las tablas "mdl_external_services" y "mdl_external_services_functions", debido a que las funciones Javascript están registradas como librerías externas para acceder a los datos, modificar o eliminar registros.



### Como instalar ###

Para subirlos a Moodle, lo recomendable es comprimir las carpetas por separado, en formato ZIP y posteriormente subirlos mediante la opción de Subir Extensiones en la sección de Administración (Administración del Sitio -> Extensiones -> Instalar módulos externos). 

* Summary of set up
* Configuration
* Dependencies
* Database configuration
* How to run tests
* Deployment instructions

### Contribution guidelines ###

* Writing tests
* Code review
* Other guidelines

### Who do I talk to? ###

* Repo owner or admin
* Other community or team contact