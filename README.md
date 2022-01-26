Cabe mencionar que para que los datos se aprecien mejor debemos utilizar una herramienta o script
llamada jq que nos muestra un formato json mas amigable en nuestras consultas

Operaciones con la linea de comandos de Windows

Operaciones con GET antes de incluir un router (URL amigables)
GET:

curl http://localhost:8000?resource_type=books -v

GET elemento especifico

curl "http://localhost:8000?resource_type=books&resource_id=1" -v

Operaciones con GET despues de incluir un router (URL amigables)

GET todo un conjunto de datos
curl http://localhost:8000/books

GET un dato especifico de un conjunto de datos:

curl http://localhost:8000/books/1

POST

Post en linux

curl -X 'POST' http://localhost:8000/books -d '{"titulo": "Nuevo libro", "id_autor:" 1, "id_genero": 2}'

Post en windows (CMD no admite comillas sencillas)

curl -X "POST" http://localhost:8000/books -d "{ \"titulo\":\"Nuevo Libro\",\"id_autor\": 1,\"id_genero\": 2}"

PUT 

Windows 

curl -X "PUT" http://localhost:8000/books/1 -d "{ \"titulo\":\"Libro Modificado\",\"id_autor\": 10,\"id_genero\":18}"

DELETE 

curl -X "DELETE" http://localhost:8000/books/1

Cuando agregamos una authenticacion de forma sencilla (se debe usar una base de datos, pero esta vez se usara esta forma sencilla pero no recomendada)

Dentro del codigo de php tenemos que estan seteados las credenciales

Entonces despues si solo hacemos un get sencillo este no mostrara nada, sin embargo, le pasamos los datos de claves, en esta ocacion de forma sencilla tendremos que hacer la consulta asi

curl http://alonso:1234@localhost:8000/books

Sin embargo la autenticacion http es totalmente insegura, e ineficiente porque en cada pedido se debe realizar la autenticacion

//Buscamos si hay un usuario authenticado en el server
$user = array_key_exists('PHP_AUTH_USER', $_SERVER) ? $_SERVER['PHP_AUTH_USER'] : '';
$pwd = array_key_exists('PHP_AUTH_PW', $_SERVER) ? $_SERVER['PHP_AUTH_PW'] : '';

//Hacemos una validacion sencilla pero para nada recomendada

if ($user !== 'alonso' || $pwd !== '1234'){

    die;
}

Autenticacion con HMAC informacion muy segura, pero no tan confiable

Para esta autenticacion usamos 3 elementos importantes, un hash, una marca de tiempo y un id de usuario

La consulta para CMD windows:
curl http://localhost:8000/books -H "X-HASH: c63b400cb45cbf93e4da1ce4b300a3789ba53672" -H "X-UID: 1" -H "X-TIMESTAMP: 1635635550"

¿De donde saque los datos?

De la consulta con generate_hash.php en donde debemos correrlo de la siguiente forma: 

php generate_hash.php 1

Tokens!

Tenemos que habilitar el servidor de autenticacion

php -S localhost:8001 auth_server.php

tenemos que hacer una peticion post :

curl http://localhost:8001 -X "POST" -H "X-CLient-Id: 1" -H "X-Secret:SuperSecreto!"

informacion dentro de auth_server.php linea 17

Para poder hacer una peticion al servidor de recuros debemos de incluir el token generado

curl http://localhost:8000/books -H "X-Token:5d0937455b6744.68357201"


Manejo de errores--

Con el manejo de errores dentro de client.php se debe de quitar la parte de autenticacion con tokens dentro del server.php, ya que al hacer comunicacion con el servidor este mandara siempre un 200, aunque no nos devuelva nada, ya que en las primeras lineas se nos muestra un die, con el que php siempre interpreta una correcion valida

De esta forma ya se pueden enviar los errores correctamente a la consola

Creacion de nuestro apirest comunicacion con un frontend html

Creamo un archivo index.html, es importante ajustar ahora dentro de router una serie de comprobaciones con la url del sitio para que, una vez levantado de nuevo el servidor php, este muestre en el navegador la interfaz html

# Iniciamos nuestro servidor con php -S localhost:8000 router.php 

Sin tener activada la parte de la autenticacion de datos, como tokens, usuarios, etc.

Una vez hecho eso dentro de html tenemos que usar ajax, para realizar las peticiones y solicitudes dentro de nuestro servidor, tales como GET (opcion por defecto de ajax en method) y POST (para agregar un libro, aunque bien sabemos que no se guardaran mas que en el DOM existente de la peticion activa)

Informacion dentro del index.html