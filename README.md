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

