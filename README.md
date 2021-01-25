# README #

Este repo consiste en 2 plugins creados para Moodle, usados para registro de usuarios.
El problema que se desea resolver es, cuando un usuario requiere registrar una lista de campos múltiples, por ejemplo: 	
	Capacitaciones externas a Moodle que haya realizado:
	
![alternativetext](ejemplos/ejemplo%20plugin.png)

### OBJETIVOS ###

* Version 1.0

El repositorio actual posee 2 plugins:
* COMPOUND: Permite crear un tipo de campo personalizado, con filas de campos. Utiliza una librería Javascript para crear este listado (https://github.com/json-editor/json-editor), por lo que debe cumplir con las pautas de dicha librería para crear el formulario.
Crea los campos personalizados en la tabla "mdl_user_info_field".


* JSONFORM: Este plugin crea el formulario, lo presenta en pantalla y guarda los datos usando AJAX. Al instalarlo, crea registros en las tablas "mdl_external_services" y "mdl_external_services_functions", debido a que las funciones Javascript están registradas como librerías externas para acceder a los datos, modificar o eliminar registros.



### Como instalar ###

Para subirlos a Moodle, es necesario comprimir las carpetas por separado, en formato ZIP y posteriormente subirlos mediante la opción de Subir Extensiones en la sección de Administración (Administración del Sitio -> Extensiones -> Instalar módulos externos). 
Posteriormente, el plugin instalado, creará los registros y el tipo de dato necesario para este tipo de campo.
El orden de instalación es el siguiente:

* Plugin Compound
* Plugin Jsonform


### Dependencias ###

* Moodle 3.10.1 (Build: 20210118), en adelante.
* Librería [JsonEditor](https://github.com/json-editor/json-editor), que ya está incluída.
 

### Constribuciones y dudas ###

* Comunicarse a Pablo Millaquén [email](pablomillaquen@gmail.com)