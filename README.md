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